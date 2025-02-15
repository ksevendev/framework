<?php

namespace Core\Middleware\Api;

use Firebase\JWT\JWT;
use Exception;

class AuthMiddleware
{
    public function handle($request, $next)
    {
        $headers = getallheaders();
        
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Token não encontrado']);
            exit;
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        
        // Obter a chave secreta do arquivo de configuração
        $config = require __DIR__ . '/../../config/config.php';
        $jwtSecret = $config['jwt']['secret_key'];
        
        try {
            $decoded = JWT::decode($token, $jwtSecret, ['HS256']);
            // Colocar o usuário decodificado na requisição
            $request->user = $decoded;
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => 'Token inválido']);
            exit;
        }

        return $next();
    }
}
