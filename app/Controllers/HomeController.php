<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\User;

class HomeController extends BaseController
{

    public function index()
    {

        $model = new User();
        $users = $model::all();

        var_dump($users);
        exit;

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
