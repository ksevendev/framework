<?php

namespace Core\Middleware\Web;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class SessionMiddleware
{
    public function handle(\Closure $next)
    {
        // Cria uma instância de Request a partir das variáveis globais
        $request = Request::createFromGlobals();
        $session = new Session();

        if (!$session->isStarted()) {
            // Inicializa a sessão do Symfony (o Symfony cuidará de iniciar a sessão)
            $session->start();  // O Symfony só inicia a sessão uma vez automaticamente
        }

        // Passa a requisição para o próximo middleware ou controlador
        return $next($request);
    }
}
