<?php

namespace App\Middleware;

use App\Middleware\BaseMiddleware;

class CorsMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        return $next($request);
    }
}
