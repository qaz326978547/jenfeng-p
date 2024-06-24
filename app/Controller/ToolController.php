<?php

namespace App\Controller;

use App\Controller\UploadTrait;
// use App\ClassMap\ChineseConversion;

class ToolController
{
    use UploadTrait;

    /**
     * Ajax 驗證
     */
    public function ajax_validate()
    {
        // 驗證器
        validate(config(\Request::input('rule')), config(\Request::input('rule_message')), \Request::input('validate_path'));

        return \JsonResponse::create([])->send();
    }

    /**
     * 暫存輸入資料
     */
    public function ajax_temp_input()
    {
        $key_string = \Request::input('key_string');

        if (!empty($key_string)) {
            \Session::put($key_string,
                \Collection::make(\Session::get($key_string, []))
                           ->merge(\Request::except('key_string'))
                           ->toArray()
            );
        }

        return \JsonResponse::create([])->send();
    }

    /**
     * 驗證碼
     */
    public function captcha()
    {
        $a = rand(0, 9);
        $b = rand(0, 9);
        $c = rand(0, 9);
        $d = rand(0, 9);
        $e = rand(0, 9);
        $f = rand(0, 9);

        $code = $a . $b . $c . $d . $e . $f;

        \Session::put('captcha', $code);

        $font = __DIR__ . "/../../storage/captcha/" . rand(1, 5) . ".ttf";

        ob_start();
        $im = imagecreate(80, 25);
        $bg = imagecolorallocate($im, 217, 217, 217);
        $color = imagecolorallocate($im, 0, 0, 0);
        imagettftext($im, 12, rand(-3, 3), 5, 16, $color, $font, $code);
        imagejpeg($im);
        $content = ob_get_clean();

        return \Response::create($content, 200, ['Content-type' => 'image/jpeg'])->send();
    }

    /**
     * 檔案下載
     */
    public function download($table, $column, $id, $inline_name = '')
    {
        // 區分多個檔案
        $note = \Request::query('note', '');
        $note = empty($note) ? '' : '_' . $note;
        // --

        $data = \DB::table($table)->where([['act', 1], ['del', 0]])->find($id);

        if (empty($data)) {
        	return redirect('500')->withErrors('檔案不存在')->send();
        }

        $name = $data['name'];

        $file_path = $data[$column];
        $file_size = \Storage::size($data[$column]);
        $file_mimetype = \Storage::mimeType($data[$column]);
        $file_type = strrchr($data[$column], ".");
        $file_name = empty($name) ?
                    \File::name(storage_path($file_path)) . $note . $file_type :
                    $name . $note . $file_type;

        // if (\Session::get('lang') == 'cn') {
        // 	// 繁轉簡 (通常用不到)
        //     $chinese = new ChineseConversion();
        //     $file_name = $chinese->big5_gb2312($file_name);
        // }

        if (\Agent::browser() == 'IE') {
            $file_name = rawurlencode($file_name);
        }

        if (\Str::contains(\Agent::getUserAgent(), 'Line') && \Str::contains($file_type, ['pdf', 'docx'])) {
            return \Redirect::create('https://docs.google.com/viewer?embedded=true&url=' . host_path(storage_path($file_path)))->send();
        }

        $content_disposition = 'attachment; filename="' . $file_name . '"';

        if (\Agent::is('iPhone')) {
            $content_disposition = "attachment; filename*=UTF-8''". rawurlencode($file_name);
        }

        $expire = 1024;
        $headers = [
            'Pragma'                    => 'public',
            'Cache-control'             => 'max-age=' . $expire,
            'Cache-Control'             => 'no-store, no-cache, must-revalidate',
            'Expires'                   => \Date::now()->addSeconds($expire)->format('D, d M Y H:i:s') . ' GMT',
            'Last-Modified'             => \Date::now()->format('D, d M Y H:i:s') . ' GMT',
            'Content-Disposition'       => $content_disposition,
            'Content-Length'            => $file_size,
            // 'Content-type'           => 'application/force-download',
            'Content-type'              => 'application/octet-stream',
            'Content-Encoding'          => 'none',
            'Content-Transfer-Encoding' => 'binary',
        ];

        if ($file_type == '.pdf') {
            $headers['Content-type'] = 'application/pdf';
        }

        // 線上瀏覽
        if (!empty($inline_name)) {
            $headers['Content-Disposition'] = str_replace('attachment', 'inline', $headers['Content-Disposition']);
        }

        return \Response::create(\Storage::get($file_path), 200, $headers)->send();
    }
}