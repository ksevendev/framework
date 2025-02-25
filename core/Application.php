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
        //$this->environment = config('config.env') ?: 'production';
        $this->environment = getenv('APP_ENV') ?: 'production';
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

    /**
     * Verifica o ambiente da aplicação
     */
    public function environment(string ...$envs): bool
    {
        // Se não forem passados parâmetros, retorna o ambiente atual
        if (empty($envs)) {
            return $this->environment;
        }

        // Verifica se o ambiente atual está na lista de ambientes fornecidos
        return in_array($this->environment, $envs);
    }

}