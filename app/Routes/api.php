<?php

use FastRoute\ConfigureRoutes;

/**
 * @var ConfigureRoutes $router
 * @route api
 */

//use App\Controllers\HomeController;

return function (ConfigureRoutes $router) {
    $router->addRoute('GET', '/api/public', 'App\Controllers\HomeController@index');
    $router->addRoute('GET', '/api/protected', 'App\Controllers\HomeController@apiExample');
};
