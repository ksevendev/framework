<?php

namespace App\Console\Commands;

use App\Console\Command;

class MakeController extends Command
{
    protected $group       = 'Make';

    protected $name        = 'make:controller';
    
    protected $description = 'Cria um controlador.';

    public function run(array $args)
    {
        $name = $args[0] ?? 'DefaultController';
        echo "Criando controlador: $name\n";
        
        // Definir o caminho onde o controlador será gerado
        $path = "app/Controllers/{$name}.php";

        // Lógica para gerar o arquivo do controlador
        if (!file_exists($path)) {
            $controllerContent = "<?php\n\nnamespace App\Controllers;\n\nclass {$name}\n{\n    public function index()\n    {\n        echo 'Hello, World!';\n    }\n}\n";
            file_put_contents($path, $controllerContent);
            echo "Controlador '$name' criado com sucesso em $path\n";
        } else {
            echo "O controlador '$name' já existe em $path\n";
        }
    }
}
