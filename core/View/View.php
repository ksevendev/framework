<?php

namespace Core\View;

use eftec\bladeone\BladeOne;
use Core\Application;
use Core\Log\Logger;

class View extends BladeOne
{

    protected static ?Logger $Logger = null;

    protected static array $sharedData = []; // Dados globais para todas as views

    public function __construct($templatePath = null, $compiledPath = null, $mode = 0, $commentMode = 0)
    {
        if ($templatePath === null) {
            $templatePath = __DIR__ . '/../resources/views';
        }
        if ($compiledPath === null) {
            $compiledPath = __DIR__ . '/../storage/cache/views';
        }

        parent::__construct($templatePath, $compiledPath, $mode, $commentMode);

        if (self::$Logger === null) {
            self::$Logger = new Logger("Views");
        }

    }

    /**
     * Renderiza uma view (agora pode ser chamada de forma estática)
     */
    public static function render(string $view, array $data = []): string
    {
        try {
            return self::getInstance()->run($view, $data);
        } catch (\Exception $e) {
            // Log the error
            self::$Logger->info("View not found: " . $view);
            
            // Return a custom error message or page
            return "Erro: A view '{$view}' não foi encontrada.";
        }
    }

    /**
     * Registra um helper global para facilitar o uso de views
     */
    public static function registerHelper()
    {
        if (!function_exists('view')) {
            function view(string $view, array $data = []): string
            {
                return View::render($view, $data);
            }
        }
    }

    public static function internalRender($name, $data) 
    {
        // Caminho absoluto correto para as views padrão e personalizadas
        $defaultViewPath = __DIR__ . '/../View/erros';  // Path para a view padrão
        $customViewPath = __DIR__ . '/../../../app/views/erros';  // Path para views personalizadas

        // Verifica se a view personalizada existe
        $viewPath = file_exists($customViewPath . "/" . $name . ".blade.php") ? $customViewPath : $defaultViewPath;

        // Instancia o Blade com os caminhos das views
        $blade = new View(
            $viewPath, // Pasta de views
            __DIR__ . '/../storage/cache/views', // Cache de views compiladas
            View::MODE_DEBUG,
            0
        );
        return $blade->render($name, $data);
    }
}
