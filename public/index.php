<?php

use function FastRoute\simpleDispatcher;
use FastRoute\ConfigureRoutes;
use FastRoute\Dispatcher;
use Core\Middleware\MiddlewareHandler;

require_once __DIR__ . '/../vendor/autoload.php';

// Diretório de Bootstrap
$BootstrapDir = __DIR__ . '/../app/Bootstrap/';

// Carrega os arquivos essenciais
require_once $BootstrapDir . 'app.php';
require_once $BootstrapDir . 'components.php';
require_once $BootstrapDir . 'helper.php';

$middlewareConfig = require $BootstrapDir . 'middleware.php';

// Diretório das rotas
$RoutesDir = __DIR__ . '/../app/Routes/';

// Buscar todos os arquivos de rota
$routeFiles = glob($RoutesDir . '*.php');
$routeCallbacks = [];

foreach ($routeFiles as $file) {
    $conteudo = file_get_contents($file);

    if (preg_match('/@route\s+(web|api|console)/', $conteudo, $matches)) {
        $route = require $file;
        if (is_callable($route)) {
            $routeCallbacks[] = $route;
        }
    }
}

// Criar o dispatcher das rotas
$dispatcher = simpleDispatcher(
    function (ConfigureRoutes $router) use ($routeCallbacks) {
        foreach ($routeCallbacks as $route) {
            $route($router);
        }
    },
    [
        'cacheDriver'   => FastRoute\Cache\FileCache::class,
        'cacheDisabled' => config('config.debug', false), // Habilita cache apenas em produção
        'cacheFile'     => __DIR__ . '/../storage/cache/route.cache',
    ]
);

// 🔹 Obter método e URI da requisição
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// 🔹 Determinar se é API ou Web
$isApi = str_starts_with($uri, '/api');

// 🔹 Configurar middlewares globais
$globalMiddlewares = $middlewareConfig[$isApi ? 'api' : 'web'] ?? [];

// 🔹 Processar rota
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        response(new \Core\Controllers\NotFoundController, 'index');
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        response(new \Core\Controllers\NotAllowController, 'index');
        break;

    case Dispatcher::FOUND:
        [$handler, $vars] = [$routeInfo[1], $routeInfo[2]];

        // 🔹 Adicionar middlewares específicos da rota
        $middlewares = $globalMiddlewares;
        if (isset($middlewareConfig['routeSpecific'][$uri])) {
            $middlewares = array_merge($middlewares, $middlewareConfig['routeSpecific'][$uri]);
        }

        // 🔹 Executar middlewares e chamar o handler da rota
        (new MiddlewareHandler($middlewares))->handle($_SERVER, function () use ($handler, $vars) {
            if (is_callable($handler)) {
                response($handler, $vars);
            } elseif (is_string($handler) && str_contains($handler, '@')) {
                [$class, $method] = explode('@', $handler);
                class_exists($class) && method_exists($class, $method)
                    ? response(new $class, $method, $vars)
                    : response(new \Core\Controllers\InternalController, 'index');
            } else {
                response(new \Core\Controllers\InternalController, 'index');
            }
        });
        break;
}

/**
 * Função auxiliar para chamar controllers e handlers
 */
function response($controller, string $method = 'index', array $params = [])
{
    echo call_user_func_array([$controller, $method], $params);
}
