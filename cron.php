<?php // AhWei - fezexp9987@gmail.com - line: fezexp

require __DIR__ . '/vendor/autoload.php';
$check_system_key = config('system.key');
require __DIR__ . '/setting/core.php';

/**
 * Cpanel上 工作排程指令寫法
 *
 * @example /usr/bin/php /home/主機名稱/public_html/網站名稱/cron.php job=test host=子網域 check=cpanel
 */

$job = Request::query('job');
$host = Request::query('host');
$check = Request::query('check');

empty($job) and exit('非法操作');
empty($host) and exit('非法操作');
empty($check) and exit('非法操作');

$url = 'http://' . $host . config('system.base_path') . 'cron/' . $job . '?check=' . $check;

file_get_contents($url);