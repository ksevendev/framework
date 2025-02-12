<?php

    namespace System\Config;

    use Dotenv\Dotenv;

    class BaseConfig
    {
        public function loadEnv()
        {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }
    }
