<?php

namespace App\Middleware;

class Csrf
{
    public function handle()
    {
        $csrf_path_except = !empty(config('system.csrf.path_except')) ? config('system.csrf.path_except') : [];
        $csrf_input_except = !empty(config('system.csrf.input_except')) ? config('system.csrf.input_except') : [];

		if (!in_array(\Request::method(), ['HEAD', 'GET', 'OPTIONS'])) {
			if (
				count(array_intersect(array_keys(\Request::input()), $csrf_input_except)) <= 0 &&
				!\Str::contains(\Request::path(), $csrf_path_except)
			) {
				$token = \Request::input('_token') ?: \Request::header('X-CSRF-TOKEN');

				if (!is_string(\Session::token()) || !is_string($token) || !hash_equals(\Session::token(), $token)) {
					if (!\Request::ajax()) {
						return back()->withErrors('連線逾時，請重新在操作一次 (If the connection is overdue, please re-operate once.)')->send();
					} else {
						return \JsonResponse::create([], 405)->send();
					}
				}
			}
		}

        return 'success';
    }
}