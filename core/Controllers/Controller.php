<?php

namespace Core\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Psr\Log\LoggerInterface;
use Illuminate\Container\Container;

class Controller
{
    protected array $helpers = [];

    protected Request $request;

    protected Response $response;

    protected Session $session;

    protected LoggerInterface $logger;

    protected bool $forceHTTPS = false;

    public function __construct(Request $request, Response $response, Session $session, LoggerInterface $logger)
    {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;

        $this->logger = $logger;

        $this->forceHTTPS = env('FORCE_HTTPS') === true ?? (config("config.force_https") ?? false);

        if ($this->forceHTTPS) {
            $this->forceHTTPS();
        }

        // Autoload helper files
        $this->loadHelpers();
    }

    /**
     * Força a conexão HTTPS
     */
    protected function forceHTTPS()
    {
        if (!$this->request->isSecure()) {
            $this->response->headers->set('Location', 'https://' . $this->request->getHost() . $this->request->getRequestUri());
            $this->response->setStatusCode(301);
            $this->response->send();
            exit;
        }
    }

    /**
     * Define um cookie seguro
     */
    public function setCookie(string $name, string $value, int $expire = 3600, string $path = '/', string $domain = '', bool $secure = true, bool $httpOnly = true)
    {
        $cookie = Cookie::create($name, $value, time() + $expire, $path, $domain, $secure, $httpOnly);
        $this->response->headers->setCookie($cookie);
    }

    /**
     * Obtém um cookie
     */
    public function getCookie(string $name)
    {
        return $this->request->cookies->get($name);
    }

    /**
     * Define uma variável de sessão
     */
    public function setSession(string $key, $value)
    {
        $this->session->set($key, $value);
    }

    /**
     * Obtém uma variável de sessão
     */
    public function getSession(string $key)
    {
        return $this->session->get($key);
    }

    /**
     * Valida os dados recebidos
     */
    public function validate(array $rules): bool
    {
        // Simulação de um validador
        foreach ($rules as $field => $rule) {
            if (empty($this->request->request->get($field))) {
                return false;
            }
        }
        return true;
    }

    /**
     * Carrega os helpers automaticamente
     */
    protected function loadHelpers()
    {
        foreach ($this->helpers as $helper) {
            require_once __DIR__ . '/../Helpers/' . $helper . '.php';
        }
    }

    /**
     * Retorna uma resposta JSON padronizada
     */
    public function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Renderiza uma página HTML simples
     */
    public function view(string $view, array $data = [], array $mergeData = [])
    {
        // Obtém a instância do View corretamente
        //return app(\Core\View\View::class)->render($view, $data);
        return view($view, $data);
    }

    /**
     * Renderiza uma página HTML simples
     */
    public function v(string $view, array $data = [], array $mergeData = [])
    {
        // Obtém a instância do View corretamente
        return app(\Core\View\View::class)->internalRender($view, $data);
    }

    /**
     * Retorna um erro em JSON
     */
    public function errorResponse($message, $status = 400)
    {
        $this->jsonResponse(['error' => $message], $status);
    }
}
