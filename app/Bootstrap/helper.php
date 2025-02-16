<?php

use Core\Components\ComponentBase;
/*
if (!function_exists('view')) {
    function view($view, $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            extract($data); // Extrai dados para a view
            ob_start();
            require $viewPath;
            return ob_get_clean();
        }

        throw new \Exception("View {$view} não encontrada.");
    }
}

if (!function_exists('component')) {
    function component($name, $data = [])
    {
        $componentManager = new ComponentBase();
        return $componentManager->renderComponent($name, $data);
    }
}

if (!function_exists('url_to')) {
    function url_to($route, $params = [])
    {
        // Aqui você pode definir um roteamento de URLs baseado no seu sistema
        $routes = [
            'home' => '/',
            'profile' => '/profile/{id}',
            'post' => '/post/{slug}',
        ];

        $url = $routes[$route] ?? null;

        if ($url) {
            foreach ($params as $key => $value) {
                $url = str_replace('{' . $key . '}', $value, $url);
            }
        }

        return $url ?? '#';
    }
}

if (!function_exists('asset')) {
    function asset($path)
    {
        return base_url('public/' . $path);
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        $baseUrl = $_SERVER['HTTP_HOST'];
        return "http://{$baseUrl}/{$path}";
    }
}
*/

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        static $configs = [];

        if (empty($configs)) {
            foreach (glob(__DIR__ . '/../Config/*.php') as $file) {
                //$name = basename($file, '.php');
                $name = strtolower(basename($file, '.php')); // Força minúsculas
                $configs[$name] = require $file;
            }
        }

        $keys = explode('.', $key);
        $value = $configs;

        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        return $_ENV[$key] ?? getenv($key) ?? $default;
    }
}

if (!function_exists('csrfTokenField')) {
    function csrfTokenField()
    {
        // Gera o token CSRF se ele ainda não foi gerado
        //$csrf = new \Core\Security\CSRF();
        //$csrf->generateToken();
        
        // Recupera o token da sessão (já gerado)
        $session = new \Symfony\Component\HttpFoundation\Session\Session();
        $name = config('security.cookie_name');
        if ($session->has($name)) {
            $token = $session->get($name);
            // Retorna o campo CSRF para ser inserido no formulário
            return '<input type="hidden" name="' . $name . '" value="' . $token . '">';
        }
        return null;

    }
}