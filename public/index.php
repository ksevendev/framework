<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use App\Middleware\MiddlewareHandler;
use function FastRoute\simpleDispatcher;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/app.php';   // Inicializa a configuração básica
require_once __DIR__ . '/../bootstrap/view.php';  // Carrega o sistema de views
require_once __DIR__ . '/../bootstrap/components.php';  // Carrega o sistema de components

require_once __DIR__ . '/../bootstrap/helper.php';  // Carrega o helper global

// Carregar middlewares do arquivo de configuração
$middlewareConfig = require __DIR__ . '/../bootstrap/middleware.php';

// Definir rotas de API e Web
$routesApi = require __DIR__ . '/../routes/api.php';
$routesWeb = require __DIR__ . '/../routes/web.php';

// Criar o dispatcher com as rotas
$dispatcher = simpleDispatcher(function (RouteCollector $router) use ($routesApi, $routesWeb) {
    $routesApi($router);
    $routesWeb($router);
});

// Obter método e URI da requisição
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Determinar se é uma requisição para API ou Web
$isApi = str_starts_with($uri, '/api');

// Definir middlewares globais conforme tipo de requisição
$globalMiddlewares = $isApi ? $middlewareConfig['api'] : $middlewareConfig['web'];

// Processar rota
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Rota não encontrada']);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        // Adicionar middlewares específicos da rota, se houver
        $middlewares = $globalMiddlewares;
        if (isset($middlewareConfig['routeSpecific'][$uri])) {
            $middlewares = array_merge($middlewares, $middlewareConfig['routeSpecific'][$uri]);
        }

        // Executar os middlewares e a rota
        $middlewareHandler = new MiddlewareHandler($middlewares);
        $middlewareHandler->handle($_SERVER, function () use ($handler, $vars) {
            if (is_callable($handler)) {
                echo $handler(...$vars);
            } elseif (is_string($handler) && strpos($handler, '@') !== false) {
                [$class, $method] = explode('@', $handler);
                $controller = new $class();
                echo $controller->$method(...$vars);
            }
        });

        break;
}
