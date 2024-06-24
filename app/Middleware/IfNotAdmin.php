<?php

namespace App\Middleware;

class IfNotAdmin
{
    public function handle()
    {
        if (!\Session::has('admuser')) {
			if(\Request::ajax() === false) {
				return redirect('admin')->send();
			} else {
				\JsonResponse::create(['error' => '', 'location' => base_path('admin')], 403)->send();
				exit;
			}
        }

        try {
	        if (!\Session::has('adm_check') || \Crypt::decrypt(\Session::get('adm_check')) != \Session::get('admuser')) {
	            // 註銷登入資訊
	            \Session::forget('admuser');
	            \Session::forget('adm_check');

	          	return redirect('admin')->withErrors('')->send();
	        }
     	} catch (\Throwable $e) {
            // 註銷登入資訊
            \Session::forget('admuser');
            \Session::forget('adm_check');

     		return redirect('admin')->withErrors('')->send();
    	}

        return 'success';
    }
}