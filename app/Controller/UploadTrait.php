<?php

namespace App\Controller;

use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    /**
     * 圖片上傳
     *
     * @param  Illuminate\Http\UploadedFile $file
     * @param  string $folder
     * @param  string $width
     * @return string
     */
    protected function image_upload(UploadedFile $file, $folder, $width = null)
    {
        if ($file->isValid()) {
            // 儲存原始圖片
            if ($file->getClientOriginalExtension() == 'svg') {
                $image_path = \Storage::putFileAs('upload/' . $folder . '/image/' . \Date::now()->toDateString(), $file, \Str::random(40) . '.svg');
            } else {
                $image_path = \Storage::putFile('upload/' . $folder . '/image/' . \Date::now()->toDateString(), $file);
            }

            if ($file->extension() != 'gif' && $file->getClientOriginalExtension() != 'svg') {
                // 取出圖片
                $image = \Image::make(\Storage::get($image_path));
                
                if (!empty($width) && $image->width() > $width) {
	                // 圖片處理
	                $image->resize($width, null, function ($constraint) {
	                    $constraint->aspectRatio();
	                    $constraint->upsize();
	                })->encode();

	                // 覆蓋回去
	                \Storage::put($image_path, $image);	                
                }
            }

            return $image_path;
        } else {
            return '';
        }
    }

    /**
     * 檔案上傳
     *
     * @param  Illuminate\Http\UploadedFile $file
     * @param  string $folder
     * @return string
     */
    protected function file_upload(UploadedFile $file, $folder)
    {
        if ($file->isValid()) {
            $file_path = \Storage::putFile('upload/' . $folder . '/file/' . \Date::now()->toDateString(), $file);

            return $file_path;
        } else {
            return '';
        }
    }
}