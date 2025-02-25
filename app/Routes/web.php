<?php

use FastRoute\ConfigureRoutes;

/**
 * @var ConfigureRoutes $router
 * @route web
 */

use App\Controllers\HomeController;

return function (ConfigureRoutes $router) {
    $router->addRoute('GET', '/', 'App\Controllers\HomeController@index', ["_name" => "home"]);
    $router->addRoute('GET', '/sobre', 'App\Controllers\HomeController@sobre', ["_name" => "about"]);
    $router->addRoute('GET', '/url', 'App\Controllers\HomeController@url', ["_name" => "url"]);
    $router->get('/user/{id}', 'App\Controllers\UserController@profile', ['_name' => 'user_profile']);
};
