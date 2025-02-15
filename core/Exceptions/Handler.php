<?php

namespace Core\Exceptions;

use \Throwable;

class Handler
{
    public function handle(Throwable $e)
    {
        http_response_code(500);
        echo "Erro: " . $e->getMessage();
    }
}
