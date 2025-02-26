<?php

    return [

        'app_name' => env('APP_NAME', 'Mini Framework'),
        'debug' => env('APP_DEBUG', false),
        'timezone' => env('APP_TIMEZONE', 'America/Sao_Paulo'),
        'force_https' => env('FORCE_HTTPS', false),

        'base_url' => env('APP_URL', 'http://localhost'),

        'env' => env('APP_ENV', 'production'),
        'key' => env('APP_KEY', 'default_key'),
        'secret_key' => env('JWT_SECRET_KEY', 'your_default_jwt_secret'),

    ];
