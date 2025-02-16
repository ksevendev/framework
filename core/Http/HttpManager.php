<?php

namespace Core\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Cookie;

class HttpManager
{
    protected Request $request;
    protected Response $response;
    protected Session $session;

    /**
     * Construtor - Inicializa Request, Response e Session
     */
    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->response = new Response();
        $this->session = new Session();

        // Inicia a sessão, se não estiver iniciada
        if (!$this->session->isStarted()) {
            $this->session->start();
        }
    }

    /**
     * 🔹 Manipulação de Sessões
     */
    public function setSession(string $key, $value): void
    {
        $this->session->set($key, $value);
    }

    public function getSession(string $key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    public function deleteSession(string $key): void
    {
        $this->session->remove($key);
    }

    public function destroySession(): void
    {
        $this->session->invalidate();
    }

    /**
     * 🔹 Manipulação de Cookies
     */
    public function setCookie(string $name, $value, int $expire = 3600, string $path = "/", string $domain = "", bool $secure = false, bool $httponly = true): void
    {
        $cookie = new Cookie($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
        $this->response->headers->setCookie($cookie);
    }

    public function getCookie(string $name, $default = null)
    {
        return $this->request->cookies->get($name, $default);
    }

    public function deleteCookie(string $name, string $path = "/", string $domain = ""): void
    {
        $this->response->headers->clearCookie($name, $path, $domain);
    }

    /**
     * 🔹 Manipulação de Requests
     */
    public function getRequest(string $key, $default = null)
    {
        return $this->request->get($key, $default);
    }

    public function getAllRequest(): array
    {
        return $this->request->query->all() + $this->request->request->all();
    }

    public function isPost(): bool
    {
        return $this->request->isMethod('POST');
    }

    public function isGet(): bool
    {
        return $this->request->isMethod('GET');
    }

    /**
     * 🔹 Manipulação de Response
     */
    public function setResponseCode(int $code): void
    {
        $this->response->setStatusCode($code);
    }

    public function jsonResponse(array $data, int $statusCode = 200): void
    {
        $this->response->setContent(json_encode($data));
        $this->response->headers->set('Content-Type', 'application/json');
        $this->response->setStatusCode($statusCode);
        $this->response->send();
        exit;
    }

    public function redirect(string $url): void
    {
        $this->response->headers->set('Location', $url);
        $this->response->setStatusCode(302);
        $this->response->send();
        exit;
    }

    public function sendResponse(): void
    {
        $this->response->send();
    }
}
