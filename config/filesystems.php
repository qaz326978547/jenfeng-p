<?php

// --------------------- FileSystem 套件設定 ---------------------

return [
    'default' => 'local',

    'cloud' => 's3',

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => __DIR__ . '/../storage/',
            'visibility' => 'public',
		    'permissions' => [
		        'file' => [
		            'public' => 0644,
		            'private' => 0600,
		        ],
		        'dir' => [
		            'public' => 0755,
		            'private' => 0700,
		        ],
		    ],           
        ],

        'public' => [
            'driver' => 'local',
            'root' => __DIR__ . '/../storage/',
            'visibility' => 'public',
		    'permissions' => [
		        'file' => [
		            'public' => 0644,
		            'private' => 0600,
		        ],
		        'dir' => [
		            'public' => 0755,
		            'private' => 0700,
		        ],
		    ],             
        ],

   //      's3' => [
			// 'driver' => 's3',
			// 'key'    => '',
			// 'secret' => '',
			// 'region' => '',
			// 'bucket' => '',
   //      ],
    ],
];