<?php

namespace App\Controller\Admin;

class AccountController
{
    /**
     * 修改密碼頁面
     */
    public function show_upd_pw($id)
    {
        $view = \View::make('admin.account.upd_pw')->render();

        return \Response::create($view)->send();
    }

    /**
     * 修改密碼
     */
    public function upd_pw($id)
    {
        // 更新密碼
        if (\DB::table('admin')->where('id', $id)->update(['password' => \Hash::make(\Request::input('password'))])) {
            // 註銷登入資訊
            \Session::forget('admuser');

            return redirect('admin')->with('message', '密碼已更新，請重新登入')->send();
        } else {
            return back()->withErrors('密碼更新失敗')->send();
        }
    }
}