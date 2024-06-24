<?php

namespace App\Middleware;

class Redirect301
{
    public function handle()
    {
    	if (
    		config('system.env') == 'public' &&
    		config('system.redirect_301.use') == 1 &&
    		!empty(config('system.redirect_301.url')) &&
    		!empty(config('system.redirect_301.url')[0]) &&
    		!\Str::contains(\Request::header('host'), config('system.redirect_301.url'))
    	) {
    		// 預設重定向到第一個網域
    		$host = str_replace(['http://', 'https://'], '', config('system.redirect_301.url')[0]);

    		return \Redirect::create(str_replace(\Request::header('host'), $host, \Request::fullUrl()), 301)->send();
    	}

        return 'success';
    }
}