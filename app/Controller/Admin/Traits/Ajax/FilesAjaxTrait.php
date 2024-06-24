<?php

namespace App\Controller\Admin\Traits\Ajax;

trait FilesAjaxTrait
{
    /**
     * $config.
     *
     * @var array
     */
    protected $config;

    /**
     * 多檔上傳
     */
    public function ajax_files_upload()
    {
        $rule = [
            'files.*' => 'mimes:'.$this->config['multfile_mime'].'|max:'.$this->config['multfile_max_limit'],
        ];
        $rule_message = [
            'files.*.mimes' => ':attribute 檔案格式有誤 限制：:values',
            'files.*.max'   => ':attribute 檔案大小不可超過 '.get_file_max($this->config['multfile_max_limit']),
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if(\Request::hasFile('files')) {
            foreach (\Request::file('files') as $key => $file) {
	            if (in_array($file->getClientOriginalExtension(), ['jpg', 'png', 'gif'])) {
	            	$file_path = $this->image_upload($file, $this->config['folder'], 1920);
	            } else {
	            	$file_path = $this->file_upload($file, $this->config['folder']);
	            }

                if(
                    \DB::table($this->config['files_table'])->insert([
                        'pid'        => \Request::input('pid'),
                        'file'       => $file_path,
                        // 'file_type'  => $file->getClientOriginalExtension(),
                        'name'       => str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()),
                        'session_id' => \Session::getId(),
                    ])
                ) {
                    $message['success'] .= $file->getClientOriginalName() .' 新增成功 ';
                } else {
                    $message['error'] .= $file->getClientOriginalName() .' 新增失敗 ';
                }
            }
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 取得多檔資料
     */
    public function ajax_files_get($pid)
    {
        if($pid == 0) { // 新增時 顯示暫存
            $where = [['session_id', \Session::getId()], ['pid', $pid]];
        } else {
            $where = [['pid', $pid]];
        }

        $data = \DB::table($this->config['files_table'])
                   ->where($where)
                   ->orderBy('no', 'desc')
                   ->orderBy('id', 'asc')
                   ->get();

        $download_table = $this->config['files_table'];

        $html = \View::make("admin.{$this->config['folder']}.files", compact('data', 'download_table'))->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 多檔更新 選擇器
     */
    public function ajax_files_upd($pid, $id, $column)
    {
        switch ($column) {
            case 'no':
                $this->ajax_files_upd_no($id, $column);
                break;
            case 'name':
                $this->ajax_files_upd_name($id, $column);
                break;
            default:
                $message = ['success' => '', 'error' => ''];

                if (
                    \DB::table($this->config['files_table'])->where('id', $id)->update([$column => \Request::input('value')])
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
     * 多檔更新排序
     */
    protected function ajax_files_upd_no($id, $column)
    {
        $rule = ['value' => 'filled|numeric'];
        $rule_message = [
            'value.filled'  => '排序 不能為空值',
            'value.numeric' => '排序 請輸入數字',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if(
            \DB::table($this->config['files_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 多檔更新名稱
     */
    protected function ajax_files_upd_name($id, $column)
    {
        $message =['success' => '', 'error' => ''];

        if(
            \DB::table($this->config['files_table'])->where('id', $id)->update([$column => \Request::input('value')])
        ) {
            $message['success'] = '更新成功';
        } else {
            $message['error'] = '更新失敗';
        }

        return \JsonResponse::create($message)->send();
    }

    /**
     * 多檔刪除
     */
    public function ajax_files_del($pid, $id)
    {
        $message =['success' => '', 'error' => ''];

        $path = \DB::table($this->config['files_table'])->where('id', $id)->value('file');
        \Storage::delete(str_replace(storage_path(), '', $path));

        if(\DB::table($this->config['files_table'])->where('id', $id)->delete()) {
            $message['success'] = '刪除成功';
        } else {
            $message['error'] = '刪除失敗';
        }

        return \JsonResponse::create($message)->send();
    }
}