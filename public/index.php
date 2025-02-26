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
        $RouterConfig = require __DIR__ . "/../core/Config/RouterConfig.php";
        $RouterConfig($router);
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

//vdump($dispatcher);

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
        render(new \Core\Controllers\NotFoundController, 'index');
        break;

    case Dispatcher::METHOD_NOT_ALLOWED:
        render(new \Core\Controllers\NotAllowController, 'index');
        break;

    case Dispatcher::FOUND:
        [$handler, $vars] = [$routeInfo[1], $routeInfo[2]];

        // 🔹 Adicionar middlewares específicos da rota
        $middlewares = $globalMiddlewares;
        if (isset($middlewareConfig['routeSpecific'][$uri])) {
            $middlewares = array_merge($middlewares, $middlewareConfig['routeSpecific'][$uri]);
        }

        // Executar middlewares e chamar o handler da rota
        (new MiddlewareHandler($middlewares))->handle($_SERVER, function () use ($handler, $vars) {
            if ($handler instanceof Closure) {
                // Se for um Closure, chama diretamente
                echo call_user_func_array($handler, $vars); // Chama o Closure com os parâmetros
            } elseif (is_string($handler) && str_contains($handler, '@')) {
                // Caso seja uma string no formato 'Classe@Método'
                [$class, $method] = explode('@', $handler);
                if (class_exists($class) && method_exists($class, $method)) {
                    render(new $class, $method, $vars); // Chama a função render corretamente
                } else {
                    render(new \Core\Controllers\InternalController, 'index'); // Caso contrário, chama uma controller de erro
                }
            } else {
                render(new \Core\Controllers\InternalController, 'index'); // Caso o handler não seja válido, chama a controller de erro
            }
        });

        break;
}

/**
 * Função auxiliar para chamar controllers e handlers
 */
function render($controller, string $method = 'index', array $params = [])
{
    if ($controller instanceof Closure) {
        echo call_user_func_array($controller, $params);
    } else {
        echo call_user_func_array([$controller, $method], $params);
    }
}
