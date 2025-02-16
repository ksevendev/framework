<?php

namespace Core\Security;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class CSRF
{
    protected Session $session;
    protected Request $request;

    public function __construct()
    {
        $this->session = new Session();
        $this->request = Request::createFromGlobals();
    }

    // Gera o token CSRF e o armazena na sessão e em um cookie
    public function generateToken()
    {
        if (config("security.csrf_enabled")) {
            // Obtém o nome do cookie da configuração
            $cookieName = config("security.cookie_name");

            // Verifica se já existe um token CSRF gerado na sessão
            $existingToken = $this->session->get($cookieName);
            $tokenTimestamp = $this->session->get($cookieName . '_timestamp');  // Obtém o timestamp do token

            // Verifica se o token já existe e se não expirou
            if (!$existingToken || !$tokenTimestamp || time() - $tokenTimestamp > config("security.token_lifetime")) {
                // Se não existir ou se expirou, gera um novo token
                $token = bin2hex(random_bytes(32));
                $this->session->set($cookieName, $token);  // Armazena o token na sessão
                $this->session->set($cookieName . '_timestamp', time());  // Armazena o timestamp de criação do token
            }

            // Configura o cookie com o token CSRF
            setcookie(
                $cookieName,  // Nome do cookie
                $this->session->get($cookieName),  // Token CSRF armazenado na sessão
                time() + config("security.token_lifetime"),  // Tempo de vida do cookie
                config("security.cookie_path"),  // Caminho
                config("security.cookie_domain"),  // Domínio (em branco, significa o domínio atual)
                config("security.cookie_secure"),  // Se é seguro (HTTPS)
                config("security.cookie_httponly")  // Se o cookie é acessível apenas via HTTP
            );
        }
    }

    public function tokenExists(): bool
    {
        $cookieName = config("security.cookie_name");
        return $this->session->has($cookieName);
    }
    
    public function isTokenExpired(): bool
    {
        $cookieName = config("security.cookie_name");
    
        // Obtém o tempo de vida do token
        $lifetime = config("security.token_lifetime");
    
        // Obtém o tempo de criação do token armazenado na sessão
        $tokenTime = $this->session->get($cookieName . '_time', 0);
    
        // Se o token foi criado há mais tempo do que o permitido, está expirado
        return (time() - $tokenTime) > $lifetime;
    }

    // Valida o token CSRF enviado no formulário
    public function validateToken()
    {
        if (config("security.csrf_enabled")) {
            // Obtém o nome do cookie da configuração
            $cookieName = config("security.cookie_name");

            // Verifica se o token CSRF está presente na sessão e no POST
            if ($this->session->has($cookieName) && $this->request->request->get($cookieName)) {
                // Verifica se o token CSRF é válido
                if ($this->session->get($cookieName) !== $this->request->request->get($cookieName)) {
                    die('Erro CSRF: Token inválido ou expirado!');
                }
            } else {
                die('Erro CSRF: Token ausente!');
            }
        }
    }

    // Limpa o token CSRF da sessão
    public function clearToken()
    {
        $cookieName = config("security.cookie_name");
        $this->session->remove($cookieName);
        $this->session->remove($cookieName . '_timestamp');  // Remove o timestamp associado
    }
}
