<?php

namespace App\Providers;

use App\Application;
use App\Providers\ServiceProvider;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('router', function () {
            return simpleDispatcher(function (RouteCollector $router) {
                require_once __DIR__ . '/../routes/web.php';
                require_once __DIR__ . '/../routes/api.php';
            });
        });
    }
}
