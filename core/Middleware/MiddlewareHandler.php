<?php

namespace Core\Middleware;

class MiddlewareHandler
{
    protected array $middlewares;

    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function handle($request, \Closure $next)
    {
        // Processa todos os middlewares em cadeia
        $middleware = array_shift($this->middlewares);

        if ($middleware) {
            $middlewareInstance = new $middleware();

            // Chama o middleware, passando o próximo middleware ou a rota
            return $middlewareInstance->handle($next);
        }

        // Se não houver mais middlewares, executa a função de rota
        return $next($request);
    }
}
