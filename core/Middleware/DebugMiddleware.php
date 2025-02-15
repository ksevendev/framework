<?php

namespace Core\Middleware;

class DebugMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        error_log("🔍 Rota acessada: " . $_SERVER['REQUEST_URI']);
        return $next($request);
    }
}
