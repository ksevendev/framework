<?php

namespace Core\Controllers;

use Core\Controllers\Controller;

class ForbiddenController extends Controller
{
    public function __construct()
    {
        http_response_code(403);
    }

    public function index()
    {
        return $this->v('403', ['title' => "Error 500"]);
    }

}
