<?php

use App\Middleware\CorsMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\Web\CsrfMiddleware;

return [
    // Middlewares Globais para API
    'api' => [
        CorsMiddleware::class, // CORS para API
    ],
    
    // Middlewares Globais para Web
    'web' => [
        CsrfMiddleware::class, // Exemplo de CSRF para Web
    ],
    
    // Middlewares Específicos por Rota
    'routeSpecific' => [
        '/api/protected' => [AuthMiddleware::class], // Exemplo de rota protegida com middleware Auth
        '/web/protected' => [CsrfMiddleware::class],  // Exemplo de rota web com CSRF
    ]
];
