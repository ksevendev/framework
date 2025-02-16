<?php

    return [

        // Ativar ou desativar proteção CSRF
        'csrf_enabled' => env('APP_CSRF', true), 

        // Tempo de vida do token em segundos
        'token_lifetime' => env('APP_CSRF_TIME', 3600), 
        
        // Nome do cookie do token
        'cookie_name' => env('APP_CSRF_NAME', "csrf_token"), 
        
        // Definir como 'true' se a aplicação estiver usando HTTPS
        'cookie_secure' => env('APP_CSRF_SECURE', true), 
        
        // Definir como 'true' para proteger contra acesso JavaScript
        'cookie_httponly' => env('APP_CSRF_HTTPONLY', true), 

        // Caminho
        'cookie_path' => env('APP_CSRF_PATH', "/"), 

        // Domínio (em branco, significa o domínio atual)
        'cookie_domain' => env('APP_CSRF_DOMAIN', ""), 

        // Métodos para os quais a validação CSRF será aplicada
        'csrf_methods' => ['POST', 'PUT', 'DELETE'],  
    
    ];

    