<?php

// --------------------- Laravel Socialite 套件設定 (fb google 登入 等等) ---------------------

return [
    'facebook' => [
		'client_id'     => '',
		'client_secret' => '',
		'redirect'      => 'https://'.$_SERVER['HTTP_HOST'].config('system.base_path').'member/register-fb',
	],

 //    'google' => [
	// 	'client_id'     => '',
	// 	'client_secret' => '',
	// 	'redirect'      => '',
	// ],
];