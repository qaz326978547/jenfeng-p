<?php

namespace App\Controller;

use App\Controller\UploadTrait;

class HtmlEditorController
{
    use UploadTrait;

    // 編輯器-圖片管理器-單圖上傳
    public function single_image_upload()
    {
        $rule = [
            'pic' => 'mimes:jpeg,gif,png|max:2048',
        ];
        $rule_message = [
			'pic.mimes' => ':attribute 圖片檔案格式有誤 限制：:values',
			'pic.max'   => ':attribute 圖片檔案大小不可超過 2MB',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        // 檢查是否已存在的檔案
        $check_path = '';
        $check = false;
        foreach (\Storage::allFiles('upload/tinymce_editor') as $key => $path) {
            if (\Str::contains($path, \Request::input('filename'))) {
                $check_path = $path;
                $check = true;
            }
        }

        if (\Request::hasFile('pic')) {
            if ($check) {
                \Storage::put($check_path, \Image::make(\Request::file('pic'))->encode());
                $pic_path = $check_path;
            } else {
                if (!empty($pic_path = $this->image_upload(\Request::file('pic'), 'tinymce_editor', 3840))) {
                    $message['success'] = '上傳成功';
                } else {
                    $message['error'] = '上傳失敗';
                }
            }
        }

        return \JsonResponse::create(['location' => storage_path($pic_path), 'success' => $message['success'], 'error' => $message['error']])->send();
    }

    /**
     * 編輯器-圖片管理器-多圖上傳
     */
    public function multi_image_upload()
    {
        $rule = [
            'pics.*' => 'mimes:jpeg,gif,png|max:2048',
        ];
        $rule_message = [
			'pics.*.mimes' => ':attribute 圖片檔案格式有誤 限制：:values',
			'pics.*.max'   => ':attribute 圖片檔案大小不可超過 2MB',
        ];
        // 驗證器
        validate($rule, $rule_message);

        $message = ['success' => '', 'error' => ''];

        if (\Request::hasFile('pics')) {
            foreach (\Request::file('pics') as $key => $file) {
                $pic_path = $this->image_upload($file, 'tinymce_editor', 3840);

                if (!empty($pic_path)) {
                    $message['success'] .= $file->getClientOriginalName() . ' 新增成功 ';
                } else {
                    $message['error'] .= $file->getClientOriginalName() . ' 新增失敗 ';
                }
            }
        }

        return \JsonResponse::create($message)->send();
    }

    // 取得編輯器圖片資料
    public function image_get()
    {
        $pics = \Storage::allFiles('upload/tinymce_editor');

        $data = [];

        foreach ($pics as $key => $pic) {
            // $image = new \Imagick(\Storage::path($pic));
            // $comment = $image->getImageProperty('comment');

            array_push($data, [
                'pic' => $pic,
                // 'name' => $comment !== false ? $comment : '',
            ]);
        }

        $html = \View::make("common.html-editor.image-data", compact('data'))->render();

        return \JsonResponse::create(['html' => $html])->send();
    }

    /**
     * 編輯器圖片更新 選擇器
     */
    public function image_upd($column)
    {
        switch ($column) {
            // case 'name':
            //     // $this->editor_image_upd_name();
            //     break;
            default:
                return \JsonResponse::create(['無對應的方法,欄位參數：' . $column], 422)->send();
                break;
        }
    }

    /**
     * 編輯器圖片更新簡介
     */
    public function image_upd_name()
    {
        $message = ['success' => '', 'error' => ''];

        $path = \Storage::path(\Request::input('path'));
        $name = \Request::input('name');

        $image = new \Imagick($path);
        $image->commentImage($name);
        $image->writeImage($path);

        return \JsonResponse::create($message)->send();
    }

    // 刪除編輯器圖片
    public function image_del()
    {
        \Storage::delete(\Request::input('path'));

        return \JsonResponse::create($view)->send();
    }
}