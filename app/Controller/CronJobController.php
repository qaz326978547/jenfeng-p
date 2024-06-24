<?php

namespace App\Controller;

class CronJobController
{
    /**
     * 工作選擇器
     */
    public function job($name)
    {
        if (\Request::query('check') == 'cpanel') {
            switch ($name) {
                case 'test':
                    $this->test();
                    break;
                default:
                    //
                    break;
            }
        } else {
            exit('非法操作');
        }
    }

    /**
     * 測試信件
     */
    protected function test()
    {
        $To = '';

        \Mail::send('emails.contact', ['info' => 'CronJob測試信件'], function ($message) use ($To) {
            $message->to($To)->subject("這是來自" . config('system.web_title') . "的信件");
        });
    }
}