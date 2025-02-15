<?php

return [
    // Middlewares Globais para API
    'api' => [
        \Core\Middleware\Api\CorsMiddleware::class, // CORS para API
    ],
    
    // Middlewares Globais para Web
    'web' => [
        \Core\Middleware\Web\CsrfMiddleware::class, // Exemplo de CSRF para Web
    ],
    
    // Middlewares Específicos por Rota
    'routeSpecific' => [
        /*
        '/api/protected' => [
            \Core\Middleware\Api\AuthMiddleware::class, // Exemplo de rota protegida com middleware Auth
        ], 
        '/web/protected' => [
            \Core\Middleware\Web\CsrfMiddleware::class, // Exemplo de CSRF para Web
        ],
        */
    ]
];
