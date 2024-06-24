<?php

namespace App\Controller\Admin;

use App\Controller\UploadTrait;

class HtmlEditorManagerController extends Controller
{
    use UploadTrait;

    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->config = config('html_editor_manager_admin');
    }

    /**
     * 管理器頁面
     */
    public function show($class_id = 0)
    {
        $data = \DB::table($this->config['table'])
               	   ->where([['class_id', $class_id], ['del', 0]])
               	   ->orderBy('no', 'desc')
               	   ->orderBy('id', 'asc')
               	   ->get();

        $back_class_id = \DB::table($this->config['table'])->where('id', $class_id)->value('class_id');
        $now_folder_path = $this->get_path($class_id);

        $view = \View::make("{$this->config['folder']}.manager", compact('data', 'class_id', 'back_class_id', 'now_folder_path'))->with('config', $this->config)->render();

        return \Response::create($view)->send();
    }

    /**
     * 新增
     */
    public function add($class_id, $id)
    {
        // 需求狀況處理 - 需要返回 並顯示錯誤訊息
        $error = $this->condition_process();
        if (!empty($error)) {
            return back()->withErrors($error)->send();
        }

        // 針對 Request資料 做各種判斷處理
        $this->request_if();

        // 寫入資料表的內容
        $values = \Request::except('_token', '_method', 'id');

        if (\DB::table($this->config['table'])->insert($values)) {
            return back()->with('message', '新增成功')->send();
        } else {
            return back()->withErrors('新增失敗')->send();
        }
    }

    /**
     * 更新
     */
    public function upd($class_id, $id)
    {
        // 需求狀況處理 - 需要返回 並顯示錯誤訊息
        $error = $this->condition_process($id);
        if (!empty($error)) {
            return back()->withErrors($error)->send();
        }

        // 針對 Request資料 做各種判斷處理
        $this->request_if($id);

        // 寫入資料表的內容
        $values = \Request::except('_token', '_method', 'id');

        if (\DB::table($this->config['table'])->where('id', $id)->update($values)) {
            return back()->with('message', '更新成功')->send();
        } else {
            return back()->withErrors('更新失敗')->send();
        }
    }

    /**
     * 單筆刪除 / 多筆刪除
     */
    public function del($class_id, $id)
    {
        if (\Request::has('id') && is_array(\Request::input('id'))) {
            $id = \Request::input('id');
        }

        # ------ 刪除分類底下商品 ------
        $class_tree = \DB::table($this->config['table'])
						 ->where('del', 0)
						 ->orderBy('no', 'desc')
						 ->orderBy('id', 'asc')
						 ->get()
						 ->groupBy('class_id');

        \DB::table($this->config['table'])
        ->when(is_array($id), function ($query) use ($id) {
            return $query->whereIn('id', $id);
        }, function ($query) use ($id) {
            return $query->where('id', $id);
        })
        ->get()
        ->each(function ($row, $key) use ($class_tree) {
            $child_ids = get_product_rack_class_childs($row['id'], $class_tree);

            if (!empty($child_ids)) {
                $this->true_delete($child_ids, $this->config['table']);

                // 圖片刪除
                $data = \DB::table($this->config['pics_table'])->whereIn('pid', $child_ids)->pluck('pic')->toArray();
                \Storage::delete($data);
                \DB::table($this->config['pics_table'])->whereIn('pid', $child_ids)->delete();
            }
        });
        # ------------------------------

        if ($this->true_delete($id, $this->config['table'])) {
            // 圖片刪除
            $data = \DB::table($this->config['pics_table'])->where([['pid', $id]])->pluck('pic')->toArray();
            \Storage::delete($data);
            \DB::table($this->config['pics_table'])->where([['pid', $id]])->delete();

            return back()->with('message', '刪除成功')->send();
        } else {
            return back()->withErrors('刪除失敗')->send();
        }
    }

    /**
     * 需求狀況處理 - 需回傳錯誤訊息的各種狀況
     *
     * @param  int $id
     * @return string 狀況內容失敗時 回傳訊息
     */
    private function condition_process($id = 0)
    {
        //
    }

    /**
     * 透過 Request資料判斷 Request物件內容修改和執行狀況
     *
     * @param  int $id
     * @return void
     */
    private function request_if($id = 0)
    {
        if ($id == 0) {
            // history
            if ($history = $this->get_history(\Request::input('class_id'))) {
                \Request::merge(['history' => $history]);
            }
        }
    }

    /**
     * history
     *
     * @param  int $class_id
     * @param  array  $array
     * @return string
     */
    private function get_history($class_id, array $array = [])
    {
        $data = \DB::table($this->config['table'])->find($class_id);

        if (isset($data['id'])) {
            array_push($array, $data['id']);
        }

        if (isset($data['class_id']) && $data['class_id'] != 0) {
            return $this->get_history($data['class_id'], $array);
        } else {
            if (count($array) > 0) {
                return implode(';', $array);
            }
        }
    }

    /**
     * path
     *
     * @param  int $class_id
     * @return string
     */
    private function get_path($class_id)
    {
        $class = \DB::table($this->config['table'])->where([['del', 0]])->orderBy('no', 'desc')->orderBy('id', 'asc')->get()->keyBy('id');

        $now_class_id = $class_id;

        if ($class_id != 0) {
            $class_name = '';

            do {
                if ($class[$now_class_id]['class_id'] == 0) {
                    $class_name = '根目錄 > ' . $class[$now_class_id]['name'] . $class_name;
                } else {
                    $class_name = ' > ' . $class[$now_class_id]['name'] . $class_name;
                }

                $now_class_id = $class[$now_class_id]['class_id'];
            } while ($now_class_id != 0);
        } else {
            $class_name = '根目錄';
        }

        return $class_name;
    }

    /**
     * 編輯器-圖片管理器-單圖上傳
     */
    public function single_image_upload()
    {
        $rule = [
            'pic' => 'mimes:'.$this->config['multpic_mime'].'|max:' . $this->config['multpic_max_limit'],
        ];
        $rule_message = [
			'pic.mimes' => ':attribute 圖片檔案格式有誤 限制：:values',
			'pic.max'   => ':attribute 圖片檔案大小不可超過 ' . get_file_max($this->config['multpic_max_limit']),
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (\Request::hasFile('pic')) {
            $pic_path = $this->image_upload(\Request::file('pic'), $this->config['folder'], $this->config['multpic_width']);

            if (
                \DB::table($this->config['pics_table'])->insert([
                    'pid' => 0,
                    'pic' => $pic_path,
                    'session_id' => \Session::getId(),
                ])
            ) {
                $message['success'] = '上傳成功 ';
            } else {
                $message['error'] = '上傳失敗 ';
            }
        }

        return \JsonResponse::create(['location' => storage_path($pic_path), 'success' => $message['success'], 'error' => $message['error']])->send();
    }

    /**
     * 多圖上傳
     */
    public function ajax_pics_upload()
    {
        $rule = [
            'pics.*' => 'mimes:'.$this->config['multpic_mime'].'|max:' . $this->config['multpic_max_limit'],
        ];
        $rule_message = [
			'pics.*.mimes' => ':attribute 圖片檔案格式有誤 限制：:values',
			'pics.*.max'   => ':attribute 圖片檔案大小不可超過 ' . get_file_max($this->config['multpic_max_limit']),
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (\Request::hasFile('pics')) {
            foreach (\Request::file('pics') as $key => $file) {
                $pic_path = $this->image_upload($file, $this->config['folder'], $this->config['multpic_width']);

                if (
                    \DB::table($this->config['pics_table'])->insert([
                        'pid' => \Request::input('pid'),
                        'pic' => $pic_path,
                        'session_id' => \Session::getId(),
                    ])
                ) {
                    $message['success'] .= $file->getClientOriginalName() . ' 新增成功 ';
                } else {
                    $message['error'] .= $file->getClientOriginalName() . ' 新增失敗 ';
                }
            }
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 取得多圖資料
     */
    public function ajax_pics_get($pid)
    {
        $where = [['pid', $pid]];

        $data = \DB::table($this->config['pics_table'])
	               ->where($where)
	               ->orderBy('no', 'desc')
	               ->orderBy('id', 'asc')
	               ->get();

        $html = \View::make("{$this->config['folder']}.image-data", compact('data'))->with('config', $this->config)->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 多圖更新 選擇器
     */
    public function ajax_pics_upd($pid, $id, $column)
    {
        switch ($column) {
            case 'no':
                $this->ajax_pics_upd_no($id, $column);
                break;
            case 'name':
                $this->ajax_pics_upd_name($id, $column);
                break;
            case 'pid':
                $this->ajax_pics_upd_pid($id, $column);
                break;
            default:
                return \JsonResponse::create(['無對應的方法,欄位參數：' . $column], 422)->send();
                break;
        }
    }

    /**
     * 多圖更新排序
     */
    protected function ajax_pics_upd_no($id, $column)
    {
        $rule = ['value' => 'filled|numeric'];
        $rule_message = [
			'value.filled'  => '排序 不能為空值',
			'value.numeric' => '排序 請輸入數字',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['pics_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            // $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 多圖更新名稱
     */
    protected function ajax_pics_upd_name($id, $column)
    {
        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['pics_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            // $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 多圖更新pid
     */
    protected function ajax_pics_upd_pid($id, $column)
    {
        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['pics_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            // $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 多圖刪除
     */
    public function ajax_pics_del($pid, $id)
    {
        $message = ['success' => '', 'error' => ''];

        $path = \DB::table($this->config['pics_table'])->where('id', $id)->value('pic');
        \Storage::delete(str_replace(storage_path(), '', $path));

        if (\DB::table($this->config['pics_table'])->where('id', $id)->delete()) {
            $message['success'] = '刪除成功';
        } else {
            $message['error'] = '刪除失敗';
        }

        return \JsonResponse::create($message)->send();
    }
}