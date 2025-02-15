<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Carregar configurações do .env
return [
    //'app_name' => $_ENV['APP_NAME'] ?? 'Mini Framework',
    //'debug' => $_ENV['APP_DEBUG'] ?? false,
    //'timezone' => $_ENV['APP_TIMEZONE'] ?? "America/Sao_Paulo",
    'app' => [
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'key' => $_ENV['APP_KEY'] ?? 'default_key',
    ],
    'database' => [
        'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'database' => $_ENV['DB_DATABASE'] ?? 'test_db',
        'username' => $_ENV['DB_USERNAME'] ?? 'root',
        'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
    'jwt' => [
        'secret_key' => $_ENV['JWT_SECRET_KEY'] ?? 'your_default_jwt_secret',
    ]
];
