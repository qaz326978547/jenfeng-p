<?php

namespace App\Middleware;

class HttpToHttps
{
    public function handle()
    {
        if (!\Request::secure() && config('system.env') == 'public' && config('system.use_httpTohttps') == 1) {
            $start = \Str::startsWith(\Request::fullUrl(), 'http://') ? 'http://' : 'https://';
            $url = preg_replace('~' . $start . '~', 'https://', \Request::fullUrl(), 1);

            return \Redirect::create($url, 301)->send();
        }

        return 'success';
    }
}