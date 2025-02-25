<?php

use Core\View\View;

if (!function_exists('view')) {
    /**
     * Renderiza uma view Blade de forma simplificada.
     * 
     * @param string $view Nome da view (ex: 'home.index')
     * @param array $data Dados a serem passados para a view
     * @param array $mergeData Dados adicionais para mesclar
     */
    function view(string $view, array $data = [], array $mergeData = [])
    {
        try {
            // Usando a classe View para renderizar a view
            return View::render($view, $data, $mergeData); // Renderiza a view e exibe
        } catch (\Exception $e) {
            // Caso haja erro, exibe a mensagem
            die("Erro ao renderizar a view '{$view}': " . $e->getMessage());
        }
    }
}
