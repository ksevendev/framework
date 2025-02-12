<?php

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Facade;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;

use App\Components\ComponentBase;

require_once __DIR__ . '/../vendor/autoload.php';

// Criar Container Principal
$container = new Container;
Container::setInstance($container);

// Registrar o Filesystem no Container
$container->singleton('files', function () {
    return new Filesystem();
});

$container->singleton('filesystem', function ($app) {
    return new FilesystemManager($app);
});

// Inicializar Eventos e Facades
$events = new Dispatcher($container);
Facade::setFacadeApplication($container);

// Configurar Eloquent ORM
require __DIR__ . '/database.php';

// Registrar Container no Laravel para facades funcionarem
$container->instance('db', $capsule);
$container->instance('events', $events);
$container->instance('app', $container);

// Criar e carregar componentes APÓS configurar Facades
$ComponentBase = new ComponentBase();
$ComponentBase->loadComponentsFromDirectory();

// Registrar ComponentBase no Container
$container->instance('component', $ComponentBase);

return $container;
