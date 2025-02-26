<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class HomeController extends BaseController
{
    public function index()
    {

        $users = User::all();

        //return app('view')->render('default', []);
        //echo View::render('default', []);
        //return view('default', ['title' => 'Bem-vindo!']);
        return $this->view('default', ['title' => $users]);


    }

    public function url()
    {
        
        $url = config('config.base_url');
        //vdump($url);
        echo base_url('home') . "<br />";
        echo "<br />";
        echo url_to('home') . "<br />";
        echo "<br />";
        echo route_to('about') . "<br />";
        echo url_to('user_profile', ['id' => 5]) . "<br />";
        echo "<br />";
        exit;
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
