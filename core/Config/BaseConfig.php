<?php

namespace Core\Config;

use Dotenv\Dotenv;

class BaseConfig
{
    private static ?BaseConfig $instance = null;

    private function __construct()
    {
        $this->loadEnv();
    }

    public static function getInstance(): BaseConfig
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        try {
            $dotenv->load();
        } catch (\Exception $e) {
            die("❌ Erro ao carregar o .env: " . $e->getMessage());
        }
    }
}
