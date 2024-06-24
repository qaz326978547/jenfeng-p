<?php

namespace App\Controller\Admin\Traits\Ajax;

trait PicsAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 多圖上傳
     */
    public function ajax_pics_upload()
    {
        $rule = [
            'pics.*' => 'mimes:'.$this->config['multpic_mime'].'|max:'.$this->config['multpic_max_limit'],
            'pid' => [
                function($attribute, $value, $fail) {
                    $pid = $value;

                    if ($this->config['multpic_num_limit'] > 0) {
	                    $count = \DB::table($this->config['pics_table'])
	                                ->when(empty($pid), function($query) use ($pid) {
	                                    return $query->where([['pid', $pid], ['session_id', \Session::getId()]]);
	                                }, function($query) use ($pid) {
	                                    return $query->where([['pid', $pid]]);
	                                })
	                                ->count();

	                    if (($count + count(\Request::input('pics'))) > $this->config['multpic_num_limit']) {
	                        return $fail("最多上傳 {$this->config['multpic_num_limit']} 個圖片");
	                    }
	                }
                }
            ],             
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
        if ($pid == 0) {
            // 新增時 顯示暫存
            $where = [['session_id', \Session::getId()], ['pid', $pid]];
        } else {
            $where = [['pid', $pid]];
        }

        $data = \DB::table($this->config['pics_table'])
		           ->where($where)
		           ->orderBy('no', 'desc')
		           ->orderBy('id', 'asc')
		           ->get();

        $html = \View::make("admin.{$this->config['folder']}.pics", compact('data'))->with('config', $this->config)->render();

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
            default:
                $message = ['success' => '', 'error' => ''];

                if (
                    \DB::table($this->config['pics_table'])->where('id', $id)->update([$column => \Request::input('value')])
                ) {
                    $message['success'] = '更新成功';
                } else {
                    $message['error'] = '更新失敗,欄位參數：' . $column;
                }

                return \JsonResponse::create($message)->send();
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
            'value.filled' => '排序 不能為空值',
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
            $message['error'] = '更新失敗';
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
            $message['error'] = '更新失敗';
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