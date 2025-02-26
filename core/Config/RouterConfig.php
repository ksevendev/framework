<?php

use FastRoute\ConfigureRoutes;

/**
 * @var ConfigureRoutes $router
 * @route web
 */

return function (ConfigureRoutes $router) {
    // 🔹 Define uma rota para recursos
    $router->addRoute('GET', '/r/{file:.+}', function ($file) {
        render(new \Core\Controllers\ResourcesController, 'index', [$file]);
    }, ["_name" => "resources"]);
    // 🔹 Define uma rota para templates
    $router->addRoute('GET', '/t/{file:.+}', function ($file) {
        render(new \Core\Controllers\TemplateController, 'index', [$file]);
    }, ["_name" => "template"]);
};
