<?php

namespace Core\Console\Commands;

use Core\Console\Command;

class MakeModel extends Command
{
    protected $group       = 'Make';

    protected $name        = 'make:model';
    
    protected $description = 'Cria um model.';

    public function run(array $args)
    {
        $name = $args[0] ?? 'DefaultModel';
        echo "Criando model: $name\n";
        
      
    }
}
