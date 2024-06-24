<?php isset($check_system_key) or exit('No direct script access allowed'); // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

// Session 設定
if (!isset($_COOKIE[config('session.cookie')])) {
    $lifetime = config('session.expire_on_close') ? 0 : time() + config('session.lifetime') * 60;
    setcookie(
        config('session.cookie'),
        $app['session']->driver()->getId(),
        [
        	'expires' => $lifetime,
        	'path' => config('session.path'),
        	'domain' => config('session.domain'),
        	'secure' => config('session.secure'),
        	'httponly' => config('session.http_only'),
        	'samesite' => config('session.same_site'),
        ]
    );	
} else {
    $app['session']->driver()->setId($_COOKIE[config('session.cookie')]);
}

$app['session']->driver()->start();

if (random_int(1, config('session.lottery.1')) <= config('session.lottery.0')) {
    $app['session']->driver()->getHandler()->gc(config('session.lifetime') * 60);
}

if (! \Cache::has('session-gc')) {
	\Cache::put('session-gc', \Date::now()->toDateTimeString());
	$app['session']->driver()->getHandler()->gc(config('session.lifetime') * 60);
}

if (\Cache::has('session-gc') && \Date::now()->gte(\Date::parse(\Cache::get('session-gc'))->addHours(4))) {
	$app['session']->driver()->getHandler()->gc(config('session.lifetime') * 60);

	\Cache::put('session-gc', date('Y-m-d H:i:s'));	
}

register_shutdown_function([$app['session']->driver(), 'save']);

if ($app['request']->method() === 'GET' &&
    !$app['request']->ajax() &&
    !\Str::contains($app['request']->fullUrl(), 'storage') &&
    !\Str::contains($app['request']->fullUrl(), 'resources')
) {
    $app['session']->driver()->put('previous_url', $app['request']->fullUrl());
}