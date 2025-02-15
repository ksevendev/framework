<?php

namespace Core\Console\Commands;

use Core\Console\Command;

class MakeMiddleware extends Command
{
    protected $group       = 'Make';

    protected $name        = 'make:middleware';
    
    protected $description = 'Cria um middleware.';

    public function run(array $args)
    {
        $name = $args[0] ?? 'DefaultMiddleware';
        echo "Criando middleware: $name\n";
        
      
    }
}
