
<?php

use App\Application;
use Core\Exceptions\Handler;
use App\Kernel;

require_once __DIR__ . '/../../vendor/autoload.php';

// Criar a aplicação principal
$handler = new Handler();

try {
    // Inicializa o framework
    $app = new Application();
    $kernel = new Kernel($app);
    $kernel->bootstrap();
} catch (Throwable $e) {
    $handler->handle($e);
}

return $app;
