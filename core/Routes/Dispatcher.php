<?php

namespace Core\Routes;

use FastRoute\Dispatcher as CoreDispatcher;

class Dispatcher implements CoreDispatcher
{
    const NOT_FOUND = 0;
    const FOUND = 1;
    const METHOD_NOT_ALLOWED = 2;

    // Implementação do método obrigatório da interface
    public function dispatch($httpMethod, $uri)
    {
        // Aqui você pode definir a lógica para tratar as requisições.
        // Por enquanto, vamos retornar apenas um exemplo básico.
        return [self::NOT_FOUND];
    }
}
