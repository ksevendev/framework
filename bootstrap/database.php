<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Iniciar a configuração do Dotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Carregar configurações do arquivo config.php
$config = require __DIR__ . '/../config/config.php';

// Configurar o Eloquent (ou outro banco de dados)
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => $config['database']['driver'],
    'host' => $config['database']['host'],
    'database' => $config['database']['database'],
    'username' => $config['database']['username'],
    'password' => $config['database']['password'],
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
