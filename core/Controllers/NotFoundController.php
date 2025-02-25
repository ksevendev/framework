<?php

namespace Core\Controllers;

use Core\Controllers\Controller;

class NotFoundController extends Controller
{
    public function __construct()
    {
        http_response_code(404);
    }

    public function index()
    {
        return $this->v('404', ['title' => "Error 404"]);

    }

}
