<?php

namespace App\Middleware;

class BaseMiddleware
{
    public function handle($request, $next)
    {
        return $next($request);
    }
}
