<?php

namespace App\Controller\Admin;

class LoginController
{
    /**
     * 首頁
     */
    public function index()
    {
        // \Session::put('adm_check', \Crypt::encrypt(1));
        // \Session::put('admuser', 1);

        $view = \View::make('admin.login')->render();

        return \Response::create($view)->send();
    }

    /**
     * 登入
     */
    public function login()
    {
        $admin = \DB::table('admin')->where('account', \Request::input('account'))->first();

        if (\Hash::check(\Request::input('password'), $admin['password'])) {

        	\Session::put('adm_check', \Crypt::encrypt($admin['id']));
            \Session::put('admuser', $admin['id']);

		    setcookie(
		        config('session.cookie'),
		        $_COOKIE[config('session.cookie')],
		        [
		        	'expires' => 0,
		        	'path' => config('session.path'),
		        	'domain' => config('session.domain'),
		        	'secure' => config('session.secure'),
		        	'httponly' => config('session.http_only'),
		        	'samesite' => config('session.same_site'),
		        ]
		    );

            return redirect('admin/index')->with('message', '成功登入!!')->send();
        } else {
            return back()->withErrors('登入失敗, 密碼錯誤')->send();
        }
    }

    /**
     * 登出
     */
    public function logout()
    {
    	\Session::forget('adm_check');
        \Session::forget('admuser');

        return redirect('admin')->with('message', '感謝您的使用，已為您登出.')->send();
    }
}