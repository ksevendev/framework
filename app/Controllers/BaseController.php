<?php

namespace App\Controllers;

use Core\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Psr\Log\NullLogger;

class BaseController extends Controller
{
    public function __construct()
    {
        $request = Request::createFromGlobals();
        $response = new Response();
        $session = new Session();
        $logger = new NullLogger(); // Pode substituir por um logger real

        parent::__construct($request, $response, $session, $logger);
    }
}
