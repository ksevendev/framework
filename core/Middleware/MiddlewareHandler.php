<?php

namespace Core\Middleware;

class MiddlewareHandler
{
    protected array $middlewares = [];

    public function __construct(array $middlewares = [])
    {
        $this->middlewares = $middlewares;
    }

    public function handle($request, $finalHandler)
    {
        $handler = array_reduce(
            array_reverse($this->middlewares),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return (new $middleware())->handle($request, $next);
                };
            },
            $finalHandler
        );

        return $handler($request);
    }
}
