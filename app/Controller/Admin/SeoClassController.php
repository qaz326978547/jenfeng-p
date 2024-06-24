<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Controller;
// 特性
use App\Controller\Admin\Traits\Ajax\PicsAjaxTrait;

class SeoClassController extends Controller
{
    use PicsAjaxTrait;

    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    public function __construct()
    {
        $this->config = config('seo_class');
    }

    /**
     * 首頁
     */
    public function index($class_id)
    {
        $page = \Request::query('page', 1);

        // 檢查層數
        if ($this->check_level($class_id)) {
            $link_tag = str_replace('_class', '', $this->config['folder']);
            return redirect("admin/{$link_tag}/{$class_id}")->send();
        }

        $data = \DB::table($this->config['table'])
		           ->where([['class_id', $class_id], ['del', 0]])
		           ->orderBy('id', 'asc')
		           ->paginate($this->config['page_show'], ['*'], 'page', $page)
		           ->withPath(base_path(\Request::path()))
		           ->appends(\Request::query());

        $view = \View::make("admin.{$this->config['folder']}.index", compact('data', 'class_id'))->with('config', $this->config)->render();

        return \Response::create($view)->send();
    }

    /**
     * 編輯頁面
     */
    public function edit($class_id, $id)
    {
        $action = empty($id) ? 'add' : 'upd';

        // 新增時暫存清理  (清空ajax直接存入資料表的pid=0)
        if ($id == 0) {
            $this->config['multpic_set'] == 1 and $this->temp_clear($this->config['pics_table'], 'pid', $id, 'pic');
        }

        $data = \DB::table($this->config['table'])->find($id);

        $view = \View::make("admin.{$this->config['folder']}.edit", compact('data', 'action'))->with('config', $this->config)->render();

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
        $values = \Request::except('_token', '_method', 'id', 'upload_pic');

        if (\DB::table($this->config['table'])->insert($values)) {
            // 新增時暫存寫入
            $this->config['multpic_set'] == 1 and $this->temp_write($this->config['pics_table'], 'pid', $id);

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
        $values = \Request::except('_token', '_method', 'id', 'upload_pic');

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
                   $this->soft_delete($child_ids, $this->config['table']);
                   \DB::table(str_replace('_class', '', $this->config['table']))->whereIn('class_id', $child_ids)->update(['del' => 1]);
               } else {
                   \DB::table(str_replace('_class', '', $this->config['table']))->where('class_id', $row['id'])->update(['del' => 1]);
               }
           });
        # ------------------------------

        if ($this->soft_delete($id, $this->config['table'])) {
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

        // 檔案上傳
        if (count(\Request::allFiles()) > 0) {
            if (\Request::hasFile('upload_pic')) {
                $pic_path = $this->image_upload(\Request::file('upload_pic'), $this->config['folder'], $this->config['pic_width']);
                \Request::merge(['pic' => $pic_path]);
            }

            // 檔案清理
            if ($id != 0) {
                \Request::has('pic') and $this->clear_file($id, 'pic');
            }
        }
    }

    /**
     * 檢查層數
     *
     * @param  int $class_id
     * @return boolen
     */
    private function check_level($class_id)
    {
        $data = \DB::table($this->config['table'])->find($class_id);

        if (!isset($data['history'])) {
            $now_level = 0;
        } else if (!empty($data['history'])) {
            $now_level = count(explode(';', $data['history'])) + 1;
        } else {
            $now_level = 1;
        }

        if (($now_level >= $this->config['sys_level'] - 1)) {
            return true;
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
}