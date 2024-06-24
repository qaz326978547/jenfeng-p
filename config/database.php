<?php

// --------------------- 資料庫 套件設定 ---------------------

return [
    // 使用的資料庫  - MySQL Postgres SQLite SQL Server
    'default' => 'mysql',
    'fetch'      => PDO::FETCH_ASSOC,

    // 資料庫的配置
    'connections' => [
        'mysql' => [
            // --- 正式 ---
            'driver' => 'mysql',
            'host' => 'hkg1.clusters.zeabur.com',
            'port' => '32178',
            'database' => 'zeabur',
            'username' => 'root',
            'password' => 'niITxhNBgu8w7VA3p9WGf0b146ejS52t',
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'modes'     => [],
            //          // 'strict' => true,
            //          // 'engine' => null,

            // --- 測試 ---
            // 'driver'    => 'mysql',
            // 'host'      => 'localhost',
            // 'database'  => 'choice21_jinfeng',
            // 'username'  => 'root',
            // 'password'  => '',
            // 'charset'   => 'utf8mb4',
            // 'collation' => 'utf8mb4_unicode_ci',
            // 'prefix'    => '',
            // 'modes'     => [],
            // 'strict' => true,
            // 'engine' => null,
        ],
    ],
    // 'migrations' => 'migrations',
    // 'redis' => [
    //     'client' => 'predis',
    //     'default' => [
    //         'host' => env('REDIS_HOST', '127.0.0.1'),
    //         'password' => env('REDIS_PASSWORD', null),
    //         'port' => env('REDIS_PORT', 6379),
    //         'database' => 0,
    //     ],
    // ],
];
