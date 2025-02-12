<?php

use FastRoute\RouteCollector;

return function (RouteCollector $router) {
    $router->addRoute('GET', '/api/public', 'App\Controllers\HomeController@index');
    $router->addRoute('GET', '/api/protected', 'App\Controllers\HomeController@apiExample');
};
