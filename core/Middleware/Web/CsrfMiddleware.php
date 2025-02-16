<?php

namespace Core\Middleware\Web;

use Core\Security\CSRF;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CsrfMiddleware
{
    protected CSRF $csrf;

    public function __construct()
    {
        $this->csrf = new CSRF();
    }

    public function handle(\Closure $next)
    {
        $request = Request::createFromGlobals();
        $csrfMethods = config('security.csrf_methods');

        // Se o CSRF estiver ativado, verifica se o token existe e ainda é válido
        if (config('security.csrf_enabled')) {
            if (!$this->csrf->tokenExists() || $this->csrf->isTokenExpired()) {
                $this->csrf->generateToken(); // Gera um novo token
            }

            // Se a requisição exigir CSRF, valida o token
            if (in_array($request->getMethod(), $csrfMethods)) {
                $this->csrf->validateToken();
            }
        }

        return $next(); // Continua a execução da requisição
    }
}
