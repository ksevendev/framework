<?php

    return [
        'group' => env('DB_CONNECTION', 'default'),
        
        'connections' => [
            'default' => [
                'driver'    => env('DB_DRIVER', 'mysql'),
                'host'      => env('DB_HOST', '127.0.0.1'),
                'database'  => env('DB_DATABASE', 'lottery'),
                'username'  => env('DB_USERNAME', 'root'),
                'password'  => env('DB_PASSWORD', ''),
                'charset'   => env('DB_CHARSET', 'utf8mb4'),
                'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix'    => env('DB_PREFIX', ''),

            ],
            /*
            'two' => [
                'driver'    => env('DB_DRIVER', 'pgsql'),
                'host'     => env('DB_HOST', '127.0.0.1'),
                'port'     => env('DB_PORT', '5432'),
                'database' => env('DB_DATABASE', 'lottery'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
                'charset'   => env('DB_CHARSET', 'utf8'),
                'prefix'    => env('DB_PREFIX', ''),
                'schema' => env('DB_SCHEMA', 'public'),
            ],
            */
        ],
    ];
