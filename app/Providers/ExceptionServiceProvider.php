<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ExceptionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (config('system.env') == 'public') {
            // set_error_handler([$this, 'handleError']);
            set_exception_handler([$this, 'handleException']);
        }
    }

    public function register()
    {
        //
    }

    // public function handleError($errno, $errstr ,$errfile, $errline)
    // {
    //  $string = "錯誤編號: $errno\n".
    //            "錯誤訊息: $errstr\n".
    //            "錯誤檔案: $errfile\n".
    //            "錯誤行號: $errline\n";

    //  // 會在根目錄產生error_log
    //  error_log($string, 0);
    // }

    public function handleException(\Throwable $e)
    {
        if ($e instanceof \GuzzleHttp\Exception\ClientException) {
            $message = json_decode($e->getResponse()->getBody()->getContents(), true);

            // 判斷是否為FB登入
            if (isset($message['error']['fbtrace_id'])) {
                # FB登入 超出限制 例外處理
                if ($message['error']['code'] == 4) {
                    return redirect('index')->withErrors("Facebook 登入/註冊已超出限制，請30分鐘~一小時後再嘗試<br>或者請使用一般登入/註冊")->send();
                }
            }
        }

        $string = "Exception Message:\n" .
                  "Message: {$e->getMessage()}\n".
                  "Code: {$e->getCode()}\n".
                  "File: {$e->getFile()}\n".
                  "Line: {$e->getLine()}\n";

        // 會在根目錄產生error_log
        error_log($string, 0);

        \Log::channel('applog')->info($string);

        return \Response::create(\View::make('500')->render(), 500)->send();
    }
}