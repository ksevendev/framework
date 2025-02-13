<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class HomeController extends BaseController
{

    public function index()
    {
        $this->view("Bem-vindo ao mini framework!");
    }

    public function sobre()
    {
        $this->view("Página sobre nós.");
    }

    public function apiExample()
    {
        $this->jsonResponse([
            'message' => 'Exemplo de resposta JSON',
            'status' => 'success'
        ]);
    }
    
}
