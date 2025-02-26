<?php

if (!function_exists('vdump')) {
    function vdump($date, $exit = true)
    {
        echo "<pre>";
        var_dump($date);
        if ($exit) {
            exit;
        }
        echo "</pre>";
    }
}

if (!function_exists('app')) {
    /**
     * Função global para acessar o container de forma simplificada.
     */
    function app(string $abstract = null)
    {
        $app = \Core\Application::getInstance();
        return $abstract ? $app->resolve($abstract) : $app;
    }
}

if (!function_exists('page_error')) {
    function page_error(int $code = 404)
    {
       return app()->page_error($code);
    }
}

if (!function_exists('view')) {
    function view(string $view, array $data = []): string
    {
        return \Core\View\View::render($view, $data);
    }
}

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        static $configs = [];

        if (empty($configs)) {
            foreach (glob(__DIR__ . '/../app/Config/*.php') as $file) {
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

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $url = config('config.base_url');
        $base = rtrim($url, '/');
        return $path ? $base . '/' . ltrim($path, '/') : $base;
    }
}

if (!function_exists('url_to')) {
    function url_to(string $name, array $params = []): string
    {
        $route = route_to($name, $params);

        if (!$route) {
            throw new Exception("Rota '{$name}' não encontrada.");
        }

        $url = preg_replace_callback('/\{(\w+)\}/', function ($matches) use ($params) {
            $key = $matches[1];
            return $params[$key] ?? throw new Exception("Parâmetro '{$key}' não fornecido para a rota.");
        }, $route);

        return base_url($url);
    }
}

// Função auxiliar para gerar o caminho correto para arquivos dentro da pasta 'resources'
if (!function_exists('resource_path')) {
    function resource_path(string $path = '')
    {
        return realpath(__DIR__ . '/../resources') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/') : '');
    }
}

if (!function_exists('resource_to')) {
    function resource_to(string $path): string
    {
        return base_url("r/" . $path);

    }
}

if (!function_exists('template_path')) {
    function template_path(string $path = null)
    {
        $template_active = config("template.active");
        return realpath(__DIR__ . '/../templates/' . $template_active) . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/') : '');
    }
}

if (!function_exists('template_to')) {
    function template_to(string $path): string
    {
        return base_url("t/" . $path);

    }
}

if (!function_exists('public_path')) {
    function public_path(string $path = ''): string
    {
        return realpath(__DIR__ . '/../public') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/') : '');
    }
}

if (!function_exists('path_root')) {
    function path_root(string $path = ''): string
    {
        return realpath(__DIR__ . '/../') . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '/') : '');
    }
}
