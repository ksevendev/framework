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
            $dotenv->load();
        }
    }
