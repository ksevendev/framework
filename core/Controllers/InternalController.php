<?php

namespace Core\Controllers;

use Core\Controllers\Controller;

class InternalController extends Controller
{
    public function __construct()
    {
        http_response_code(500);
    }

    public function index()
    {
        return $this->v('500', ['title' => "Error 500"]);
    }

}
