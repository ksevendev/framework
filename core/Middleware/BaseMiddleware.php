<?php

namespace Core\Middleware;

class BaseMiddleware
{
    public function handle($request, $next)
    {
        return $next($request);
    }
}
