<?php

    namespace Core\Config;

    use Dotenv\Dotenv;

    class BaseConfig
    {

        public function __construct()
        {
            $this->loadEnv();
        }

        public function loadEnv()
        {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            try {
                $dotenv->load();
            } catch (\Exception $e) {
                die("❌ Erro ao carregar o .env: " . $e->getMessage());
            }
        }
    }
