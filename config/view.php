<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    'compiled' => Phar::running()
        ? $_SERVER['HOME'].'/.perscom/framework/views'
        : env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))
        ),
];
