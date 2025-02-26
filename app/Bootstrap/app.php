<?php

use Core\Application;
use Core\Exceptions\Handler;
use Core\Kernel;
use Core\Log\Logger;

require_once __DIR__ . '/../../vendor/autoload.php';

// Criar o logger
$Logger = new Logger("app");

// Criar o handler de exceções
$handler = new Handler();

try {
    \Core\Config\BaseConfig::getInstance();
    // Inicializa a aplicação utilizando o padrão Singleton
    $app = Application::getInstance();  // Usa o Singleton para obter a instância
    $kernel = new Kernel($app);  // Passa a instância do app para o Kernel
    $kernel->bootstrap();  // Realiza a inicialização do framework
} catch (Throwable $e) {
    $Logger->info($e);  // Registra o erro no log
    $handler->handle($e);  // Lida com a exceção
}

return $app;
