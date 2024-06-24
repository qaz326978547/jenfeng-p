<?php

if (!function_exists('redirect')) {
    # 重定向
    function redirect($path, $status = 302, $headers = [])
    {
        return tap(new Redirect(base_path($path), $status, $headers), function ($redirect) {
            $redirect->setSession(Session::driver());
            $redirect->setRequest(Request::instance());
        });
    }
}

if (!function_exists('back')) {
    # 上一頁
    function back($status = 302, $headers = [])
    {
        $referrer = Request::header('referer');
        $url = $referrer ? $referrer : Session::get('previous_url') ?? '/';

        return tap(new Redirect($url, $status, $headers), function ($redirect) {
            $redirect->setSession(Session::driver());
            $redirect->setRequest(Request::instance());
        });
    }
}

if (!function_exists('backTo')) {
    # 上 ? 頁
    function backTo($message, $page = 1)
    {

        Session::flash('message', $message);

        echo '<script>';
        echo 'history.go(-' . $page . ')';
        echo '</script>';
    }
}