<?php

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => Phar::running()
                ? $_SERVER['HOME'].'/.perscom/app'
                : storage_path('app'),
        ],
    ],
];
