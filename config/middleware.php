<?php

// --------------------- 中介層 ---------------------

return [

	'global' => [
		'Csrf',
		'HttpToHttps', // 線上的時候自動轉https
		'Redirect301', // 301重定向
		'NowLang', // 多語言
		'BrowseRecord', // 瀏覽記錄
	],

	'routeMiddleware' => [
		'admin'        => 'IfNotAdmin',
		'admin.guest'  => 'IfAdmin',
		'member'       => 'IfNotMember',
		'member.guest' => 'IfMember',
	],
];
