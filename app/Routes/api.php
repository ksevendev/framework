<?php

use Core\Routes\BaseRoute;

return function (BaseRoute $router) {
    $router->addRoute('GET', '/api/public', 'App\Controllers\HomeController@index');
    $router->addRoute('GET', '/api/protected', 'App\Controllers\HomeController@apiExample');
};
