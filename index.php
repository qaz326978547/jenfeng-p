<?php // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

date_default_timezone_set('Asia/Taipei');
header("X-XSS-Protection: 1; mode=block");
header("X-Frame-Options: SAMEORIGIN");
header('X-Content-Type-Options: nosniff');
header_remove('X-Powered-By');
session_start();

// 載入 套件
require __DIR__ . '/vendor/autoload.php';

$check_system_key = config('system.key');

// 載入 核心
require __DIR__ . '/setting/core.php';

// 載入 Debug 畫面
config('system.env') == 'local' AND require __DIR__ . '/setting/debug.php';

// 載入 Session
require __DIR__ . '/setting/session.php';
$app['request']->setLaravelSession($app['session']);

$anti = new guard();

// 載入 route
require __DIR__ . '/setting/route.php';