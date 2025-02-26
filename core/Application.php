<?php

namespace Core;

use Illuminate\Container\Container;

class Application extends Container
{
    public static $name = "FrameWork"; 
    
    public static $version = "1.0.0";
    
    protected static $instance = null; // Removemos o tipo da variável

    protected string $environment;

    private function __construct()
    {
        //parent::__construct();
        $this->environment = config('config.debug') ? "Development" : 'Production';
    }

    /**
     * Retorna a instância única do container (Singleton)
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Resolve uma instância de uma classe registrada no container.
     * A assinatura precisa ser idêntica à da classe `Container`.
     */
    public function resolve($abstract, $parameters = [], $raiseEvents = true)
    {
        return parent::resolve($abstract, $parameters, $raiseEvents);
    }

    /**
     * Registra um provedor de serviço na aplicação
     */
    public function register($provider)
    {
        $instance = new $provider($this);
        if (method_exists($instance, 'register')) {
            $instance->register();
        }
    }

    /**
     * Obter dados dos arquivos config/*.php
     */
    public function config(string $key, $default = null)
    {
        /*
            $config = $this->core->make('config');
            $keys = explode('.', strtolower($key));
            $value = $config;

            foreach ($keys as $segment) {
                if (!isset($value[$segment])) {
                    return $default;
                }
                $value = $value[$segment];
            }

            return $value;
        */
        
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

    /**
     * Verifica o ambiente da aplicação
     */
    public function environment(string ...$envs)
    {
        return $this->environment;
    }

    /**
     * Pagina de error
     */
    public function page_error($code = 404)
    {
        switch ($code) {
            case 403:
                render(new \Core\Controllers\ForbiddenController, 'index');
                break;
            case 404:
                render(new \Core\Controllers\NotFoundController, 'index');
                break;
            case 405:
                render(new \Core\Controllers\NotAllowController, 'index');
                break;
            case 500:
                render(new \Core\Controllers\InternalController, 'index');
                break;
            
            default:
                render(new \Core\Controllers\NotFoundController, 'index');
                break;
        }
    }

}