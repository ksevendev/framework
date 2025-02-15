<?php

namespace Core\Controllers;

class BaseController
{
 
    public function __construct()
    {
    }

    /**
     * Retorna uma resposta JSON padronizada
     */
    public function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Renderiza uma página HTML simples
     */
    public function view($content)
    {
        echo $content;
        exit;
    }

    /**
     * Retorna um erro em JSON
     */
    public function errorResponse($message, $status = 400)
    {
        $this->jsonResponse(['error' => $message], $status);
    }
}
