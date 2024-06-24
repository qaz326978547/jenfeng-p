<?php isset($check_system_key) or exit('No direct script access allowed'); // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Facade;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

$app = new Container();
$app['config'] = new Config();
$app['request'] = Request::capture();
$app['path.lang'] = __DIR__ . '/lang';

// 檢查產生app_key 讓每個網站都不一樣, 也可以手動寫入 (產生完以後 程式碼就能刪除了)
if (strpos(file_get_contents('config/mystery.php'), "'key'      => ''") !== false) {
	$key = 'base64:' . base64_encode(random_bytes(32));
	file_put_contents('config/mystery.php', str_replace("'key'      => ''", "'key'      => '{$key}'", file_get_contents('config/mystery.php')));
}

if (strpos(file_get_contents('config/session.php'), "'cookie'          => 'choice'") !== false) {
	$key = with(new \Illuminate\Support\Str)->random(16);
	file_put_contents('config/session.php', str_replace("'cookie'          => 'choice'", "'cookie'          => '{$key}'", file_get_contents('config/session.php')));
}
// -------------------------------------------------------------------------

// 載入 Config 設定
foreach (config('system.config_load') as $prefix => $config) {
	foreach (config($config) as $key => $value) {
		$app['config'][$prefix .'.'. $key] = $value;
	}
}

// 服務註冊
foreach (config('system.providers_register') as $provider) {
	with(new $provider($app))->register();
}

// Class 全域設定
Facade::setFacadeApplication($app);

foreach (config('system.aliases') as $key => $alias) {
	class_alias($alias, $key);
}

// Laravel Eloquent 啟動設定
Eloquent::setConnectionResolver($app['db']);
Eloquent::setEventDispatcher($app['events']);