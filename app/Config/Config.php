<?php

    return [
        //'app_name' => $_ENV['APP_NAME'] ?? 'Mini Framework',
        //'debug' => $_ENV['APP_DEBUG'] ?? false,
        //'timezone' => $_ENV['APP_TIMEZONE'] ?? "America/Sao_Paulo",
        'app' => [
            'env' => $_ENV['APP_ENV'] ?? 'production',
            'key' => $_ENV['APP_KEY'] ?? 'default_key',
        ],
        'jwt' => [
            'secret_key' => $_ENV['JWT_SECRET_KEY'] ?? 'your_default_jwt_secret',
        ]
    ];
