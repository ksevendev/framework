<?php

namespace Core\Console;

use Core\Console\Command;
use Illuminate\Console\Application;
use Illuminate\Container\Container;

class Kernel
{
    protected $app;

    protected $console;

    protected array $commands = [];

    public function __construct()
    {
        $this->loadCommands();
        $this->app = new Container();
        $this->console = new Application($this->app, new \Illuminate\Events\Dispatcher($this->app), '1.0.0');
    }

    // Carrega os comandos automaticamente de múltiplas pastas
    protected function loadCommands()
    {
        // Defina as pastas que contêm os arquivos de comando
        $commandPaths = [
            __DIR__ . '/Commands',          // Pasta de comandos dentro do System
            __DIR__ . '/../../app/Commands', // Pasta de comandos dentro da aplicação
            //__DIR__ . '/../../modules'      // Pasta de módulos
        ];

        foreach ($commandPaths as $path) {
            // Verifique se a pasta existe
            if (is_dir($path)) {
                // Carregue os arquivos PHP da pasta
                $commandFiles = glob($path . '/*.php');

                foreach ($commandFiles as $commandFile) {
                    // Extrai o nome da classe a partir do nome do arquivo
                    $getClass = '\\Core\\Console\\Commands\\' . basename($commandFile, '.php');
                    $class = class_exists($getClass) ? $getClass : '\\App\\Commands\\' . basename($commandFile, '.php');
                    // Verifica se a classe existe e é uma subclasse de Command
                    if (class_exists($class)) {
                        if (is_subclass_of($class, Command::class)) {
                            $instance = new $class();
                            $group = $instance->group();
                            $this->commands[$group][$instance->signature()] = $class;
                        } else {
                            echo $this->color('A classe ' . $class . ' não é uma subclasse de Command.', 'red') . "\n";
                        }
                    } else {
                        echo $this->color('Classe ' . $class . ' não encontrada.', 'red') . "\n";
                    }
                }
            } else {
                echo $this->color("A pasta $path não existe.", 'red') . "\n";
            }
        }
    }

    // Exibe o logo do sistema com cores
    protected function showLogo()
    {
        echo "\n";
        echo $this->color("Mini Framework V1.0.0 - Command Line Tool | " . date("d/m/Y H:i:s"), 'red') . "\n";
        echo $this->color("_______________________________________________________________________", 'red') . "\n";
    }

    // Exibe os comandos disponíveis com cores
    protected function showCommands()
    {
        foreach ($this->commands as $group => $cmds) {
            echo "\n" . $this->color($group, 'red') . "\n";
            foreach ($cmds as $signature => $cmdClass) {
                $command = new $cmdClass();
                echo "  " . $this->color($command->signature(), 'blue') . " - " . $command->description() . "\n";
            }
        }
        echo "\n";
    }

    // Função auxiliar para adicionar cores ao texto
    protected function color(string $text, string $color): string
    {
        $colors = [
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'blue' => "\033[34m",
            'cyan' => "\033[36m",
            'reset' => "\033[0m",
        ];

        return $colors[$color] . $text . $colors['reset'];
    }

    // Solicita a entrada do usuário caso os parâmetros não sejam passados
    protected function promptForInput(string $message): string
    {
        echo $this->color($message, 'yellow');
        $input = fgets(STDIN);
        return trim($input); // Remove o quebra de linha no final
    }

    // Executa o comando
    public function handle(array $args)
    {
        $this->showLogo();

        $command = $args[1] ?? '';

        if ($command === '' || $command === 'list') {
            $this->showCommands();
            return;
        }

        $commandFound = false;
        foreach ($this->commands as $cmds) {
            if (isset($cmds[$command])) {
                $class = $cmds[$command];
                $instance = new $class();
                $signature = $instance->signature();
                $params = $args;

                // Verifique se o comando requer parâmetros
                $reflection = new \ReflectionMethod($instance, 'run');
                $requiredParams = $reflection->getNumberOfParameters();

                // Se não houver parâmetros, executa normalmente
                if (count($params) - 2 < $requiredParams) {
                    // Solicita os parâmetros restantes
                    $missingParams = $requiredParams - (count($params) - 2);
                    for ($i = 0; $i < $missingParams; $i++) {
                        $paramName = $reflection->getParameters()[$i]->getName();
                        $paramValue = $this->promptForInput("Digite o valor para o parâmetro '$paramName': ");
                        $params[] = $paramValue;
                    }
                }

                // Chama o método do comando com os parâmetros
                $instance->run(array_slice($params, 2));
                $commandFound = true;
                break;
            }
        }

        if (!$commandFound) {
            echo $this->color("Comando '$command' não encontrado.", 'red') . "\n";
            echo $this->color("Use 'php kseven list' para ver os comandos disponíveis.", 'yellow') . "\n\n";
        }
    }

    public function handleOld($argv)
    {
        $commandName = $argv[1] ?? null;

        foreach ($this->commands as $commandClass) {
            $command = new $commandClass();
            if ($command->getName() === $commandName) {
                $command->execute();
                return;
            }
        }

        echo "Comando não encontrado.\n";
    }

    public function addCommand($command)
    {
        $this->console->add($command);
    }

    public function run()
    {
        $this->console->run();
    }

}
