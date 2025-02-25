<?php

namespace Core\Controllers;

use Core\Controllers\Controller;

class NotAllowController extends Controller
{
    public function __construct()
    {
        http_response_code(405);
    }

    public function index()
    {
        return $this->v('405', ['title' => "Error 405"]);
    }

}
