<?php

namespace Core\Debug;

use Core\Log\Logger;

class Toolbar
{
    protected static ?Logger $Logger = null;

    protected $startTime;
    protected $queriesCount = 0;
    protected $queries = [];

    public function __construct()
    {
        $this->startTime = microtime(true); // Tempo de início
        if (self::$Logger === null) {
            self::$Logger = new Logger("Toolbar");
        }
    }

    // Incrementa o contador de queries e armazena as queries detalhadas
    public function incrementQueriesCount($query)
    {
        $this->queriesCount++;
        $this->queries[] = $query; // Armazena as queries
    }

    // Retorna o tempo total de execução da aplicação
    public function getExecutionTime()
    {
        return round(microtime(true) - $this->startTime, 4);
    }

    public function addQuery($query, $bindings, $time)
    {
        $this->queries[] = [
            'query' => $query,
            'bindings' => $bindings,
            'time' => $time
        ];
    }

    // Retorna a quantidade de queries executadas
    public function getQueriesCount()
    {
        return $this->queriesCount;
    }

    // Retorna todas as queries executadas
    public function getQueries()
    {
        return $this->queries;
    }

    // Adiciona detalhes de uma query
    public function addQueryDetails(array $queryDetails)
    {
        $this->queries[] = $queryDetails;
    }
    
    public function registerDatabaseQueryListener()
    {
        $db = app()->make('db');  // Supondo que você tenha uma instância do banco de dados configurada
        
        // Intercepta as queries executadas no banco
        $db->listen(function ($query) {
            $this->incrementQueriesCount($query);
            $this->addQuery($query->sql, $query->bindings, $query->time);
        });
    }

    // Renderiza a toolbar

    public function render()
    {
        echo '<div style="position: fixed; bottom: 0; left: 0; right: 0; background-color: #333; color: white; padding: 10px; z-index: 9999; font-family: Arial, sans-serif; font-size: 12px; box-shadow: 0 -2px 5px rgba(0,0,0,0.3);">';
        echo '<strong>' . app()::$name . ' ' . app()::$version . '</strong> | ';
        echo 'Execution Time: ' . $this->getExecutionTime() . 's | ';
        echo 'Environment: ' . app()->environment('local');
        echo '</div>';
    }
    
    public function renderx()
    {
        
        // Caminho absoluto correto para as views padrão e personalizadas
        $defaultViewPath = __DIR__ . '/views';  // Path para a view padrão
        $customViewPath = __DIR__ . '/../../../app/debug/views';  // Path para views personalizadas

        // Verifica se a view personalizada existe
        $viewPath = file_exists($customViewPath . "/toolbar.blade.php") ? $customViewPath : $defaultViewPath;

        // Instancia o Blade com os caminhos das views
        $blade = new \Core\View\View(
            $viewPath, // Pasta de views
            __DIR__ . '/../storage/cache/views', // Cache de views compiladas
            \Core\View\View::MODE_DEBUG,
            0
        );

        $title = "FrameWork";
        $executionTime = $this->getExecutionTime();
        $queriesCount = $this->getQueriesCount();
        $queries = $this->getQueries();

        return $blade->render("toolbar", compact("title", "executionTime", "queriesCount", "queries"));
    }

}
