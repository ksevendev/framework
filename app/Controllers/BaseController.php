<?php

namespace App\Controllers;

class BaseController
{
    /**
     * Retorna uma resposta JSON padronizada
     */
    protected function jsonResponse($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Renderiza uma página HTML simples
     */
    protected function view($content)
    {
        echo $content;
        exit;
    }

    /**
     * Retorna um erro em JSON
     */
    protected function errorResponse($message, $status = 400)
    {
        $this->jsonResponse(['error' => $message], $status);
    }
}
