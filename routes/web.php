<?php

use FastRoute\RouteCollector;

use App\Controllers\HomeController;

return function (RouteCollector $router) {
    $router->addRoute('GET', '/', 'App\Controllers\HomeController@index');
    $router->addRoute('GET', '/sobre', 'App\Controllers\HomeController@sobre');
};

/*
return function (RouteCollector $router) {
    $router->addRoute('GET', '/', function () {
        echo "Bem-vindo ao Mini Framework!";
    });

    $router->addRoute('GET', '/sobre', function () {
        echo "Sobre nós";
    });
};
*/