<?php

namespace Core\Middleware\Web;

class CsrfMiddleware
{
    public function handle($request, $next)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['_csrf'])) {
            http_response_code(403);
            echo "CSRF token inválido!";
            exit;
        }

        return $next($request);
    }
}
