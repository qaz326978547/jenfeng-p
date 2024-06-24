<?php

// --------------------- Cache 套件設定 ---------------------

return [
    'default' => 'file',

    'stores' => [

        // 'apc' => [
        //     'driver' => 'apc',
        // ],

        'array' => [
            'driver' => 'array',
        ],

        // 'database' => [
        //     'driver' => 'database',
        //     'table' => 'cache',
        //     'connection' => null,
        // ],

        'file' => [
            'driver' => 'file',
            'path' => __DIR__ . '/../storage/cache/data/',
        ],

        // 'memcached' => [
        //     'driver' => 'memcached',
        //     'persistent_id' => '',
        //     'sasl' => [
        //         '',
        //         '',
        //     ],
        //     'options' => [
        //         // Memcached::OPT_CONNECT_TIMEOUT  => 2000,
        //     ],
        //     'servers' => [
        //         [
        //             'host' => '127.0.0.1',
        //             'port' => 11211,
        //             'weight' => 100,
        //         ],
        //     ],
        // ],

        // 'redis' => [
        //     'driver' => 'redis',
        //     'connection' => 'default',
        // ],
    ],

    'prefix' => 'laravel',
];