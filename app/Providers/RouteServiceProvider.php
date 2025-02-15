<?php

namespace App\Providers;

use Core\Providers\ServiceProvider;

//use App\Application;

use Core\Routes\BaseRoute;
use function FastRoute\simpleDispatcher;

class RouteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('router', function () {
            return simpleDispatcher(function (BaseRoute $router) {
                require_once __DIR__ . '/../Routes/web.php';
                require_once __DIR__ . '/../Routes/api.php';
            });
        });
    }
}
