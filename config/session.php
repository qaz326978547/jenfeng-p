<?php

// --------------------- Session 套件設定 ---------------------

return [
	'driver'          => 'file',
	'lifetime'        => 120,
	'expire_on_close' => false,
	'encrypt'         => true,
	'files'           => __DIR__ . '/../storage/session/',
	'connection'      => null,
	'table'           => 'sessions',
	'store'           => null,
	'lottery'         => [2, 20],
	'cookie'          => 'eCosu9TrNbsTCNrV',
	'path'            => '/',
	'domain'          => null,
	'secure'          => (config('system.use_httpTohttps') == 1 && config('system.env') == 'public') ? true : false,
	'same_site'		  => (config('system.use_httpTohttps') == 1 && config('system.env') == 'public') ? 'none' : 'lax',
	'http_only'       => true,
];