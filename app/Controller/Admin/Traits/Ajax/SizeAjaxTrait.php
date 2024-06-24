<?php

namespace App\Controller\Admin\Traits\Ajax;

trait SizeAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 取得Size資料
     */
    public function ajax_size_get($pid)
    {
        if ($pid == 0) {
            // 新增時 顯示暫存
            $where = [['session_id', \Session::getId()], ['pid', $pid], ['del', 0]];
        } else {
            $where = [['pid', $pid], ['del', 0]];
        }

        $data = \DB::table($this->config['size_table'])
	               ->where($where)
	               ->orderBy('no', 'desc')
	               ->orderBy('id', 'asc')
	               ->get();

        $html = \View::make("admin.{$this->config['folder']}.size", compact('data'))->with('config', $this->config)->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 新增Size
     */
    public function ajax_size_add($pid)
    {
        if (is_array(\Request::input('name'))) {
            $rule = [
                'name' => [
                    function ($attribute, $value, $fail) use ($pid) {
                        if (empty($pid)) {
                            $where = [['session_id', \Session::getId()], ['pid', $pid], ['del', 0]];
                        } else {
                            $where = [['pid', $pid], ['del', 0]];
                        }

                        $data = \DB::table($this->config['size_table'])
	                               ->where($where)
	                               ->whereIn($attribute, $value)
	                               ->orderBy('no', 'desc')
	                               ->orderBy('id', 'asc')
	                               ->pluck('name');

                        if ($data->count() > 0) {
                            $fail($data->implode(',') . ' 已存在');
                        }
                    },
                ],
            ];
            $rule_message = [
                '' => '',
            ];
        } else {
            $rule = [
                'name' => \Rule::unique($this->config['size_table'])->where(function ($query) use ($pid) {
                    if (empty($pid)) {
                        $where = [['session_id', \Session::getId()], ['pid', $pid], ['del', 0]];
                    } else {
                        $where = [['pid', $pid], ['del', 0]];
                    }

                    return $query->where($where);
                }),
            ];
            $rule_message = [
                'name.unique' => '內容重覆',
            ];
        }

        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        foreach ((array) \Request::input('name') as $key => $value) {
            if (\DB::table($this->config['size_table'])->insert(['pid' => $pid, 'name' => $value, 'session_id' => \Session::getId()])) {
                $message['success'] .= $value . " 新增成功\n";
            } else {
                $message['error'] .= $value . "新增失敗\n";
            }
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * Size更新 選擇器
     *
     * 如果不需要驗證器 就可以不用特別新增方法
     */
    public function ajax_size_upd($pid, $id, $column)
    {
        switch ($column) {
            case 'no':
                $this->ajax_size_upd_no($id, $column);
                break;
            case 'name':
                $this->ajax_size_upd_name($id, $column);
                break;
            default:
                $message = ['success' => '', 'error' => ''];

                if (
                    \DB::table($this->config['size_table'])->where('id', $id)->update([$column => \Request::input('value')])
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
     * Size更新排序
     */
    protected function ajax_size_upd_no($id, $column)
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
            \DB::table($this->config['size_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * Size更新名稱
     */
    protected function ajax_size_upd_name($id, $column)
    {
        $rule = ['value' => 'filled'];
        $rule_message = [
            'value.filled' => '名稱 不能為空值',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (
            \DB::table($this->config['size_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 刪除Size
     */
    public function ajax_size_del($pid, $id)
    {
        $message = ['success' => '', 'error' => ''];

        if ($this->soft_delete($id, $this->config['size_table'])) {
            $message['success'] = '刪除成功';
        } else {
            $message['error'] = '刪除失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * Size 自動完成
     */
    public function ajax_size_ac($value)
    {
        $data = \DB::table($this->config['size_table'])
		           ->where('name', 'like', '%' . urldecode($value) . '%')
		           ->orderBy('name', 'asc')
		           ->distinct()
		           ->pluck('name');

        return \JsonResponse::create($data)->send();
    }

    /**
     * Size 圖片
     */
    public function ajax_size_pic($id)
    {
        $rule = [
            'pic' => 'mimes:'.$this->config['size_pic_mime'].'|max:'.$this->config['size_pic_max_limit'],
        ];
        $rule_message = [
			'pic.mimes' => ':attribute 圖片檔案格式有誤 限制：:values',
			'pic.max'   => ':attribute 圖片檔案大小不可超過 ' . get_file_max($this->config['size_pic_max_limit']),
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (\Request::hasFile('pic')) {
            $pic_path = $this->image_upload(\Request::file('pic'), $this->config['folder'], $this->config['size_pic_width']);

            $old_pic_path = \DB::table($this->config['size_table'])->where('id', $id)->value('pic');
            \Storage::delete($old_pic_path);

            if (\DB::table($this->config['size_table'])->where('id', $id)->update(['pic' => $pic_path])) {
                $message['success'] = '圖片上傳更新成功';
            } else {
                $message['error'] = '圖片上傳更新失敗';
            }
        }

        return \JsonResponse::create($message)->send();
    }
}