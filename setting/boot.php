<?php isset($check_system_key) or exit('No direct script access allowed'); // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

// 服務啟動
foreach (config('system.providers_boot') as $provider) {
    with(new $provider($app))->boot();
}