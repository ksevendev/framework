<?php

namespace Core\Middleware\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RateLimitMiddleware
{
    // Definindo parâmetros de limitação de taxa
    private $limit = 100;  // Número máximo de requisições permitidas
    private $timeFrame = 60;  // Tempo de limitação em segundos (1 minuto)

    public function __construct()
    {
        // Aqui você pode configurar ou carregar parâmetros de configuração de limite, se necessário.
    }

    public function handle(\Closure $next, Request $request)
    {
        // Obtém o IP do usuário (ou outro identificador único)
        $ip = $request->getClientIp();

        // Definindo a chave para armazenar a contagem de requisições
        $key = "rate_limit_" . $ip;

        // Obtém a sessão para armazenar a contagem de requisições
        $session = $request->getSession();

        // Se não existe um contador, inicialize
        if (!$session->has($key)) {
            $session->set($key, ['count' => 0, 'timestamp' => time()]);
        }

        // Recupera os dados da contagem e timestamp
        $data = $session->get($key);
        
        // Verifica se o período de tempo já expirou
        if (time() - $data['timestamp'] > $this->timeFrame) {
            // Se o período de tempo expirou, reinicia a contagem
            $session->set($key, ['count' => 1, 'timestamp' => time()]);
        } else {
            // Caso contrário, incrementa a contagem
            if ($data['count'] >= $this->limit) {
                // Limite atingido, retorna um erro 429 (Too Many Requests)
                return new Response("Too many requests. Please try again later.", 429);
            }
            $session->set($key, ['count' => $data['count'] + 1, 'timestamp' => $data['timestamp']]);
        }

        // Passa para o próximo middleware ou controlador
        return $next($request);
    }
}
