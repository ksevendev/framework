<?php

use Jenssegers\Blade\Blade;
use Illuminate\Support\Str;

// Configuração do Blade
$views = __DIR__ . '/../Resources/Views';  // Pasta onde as views Blade serão armazenadas
$cache = __DIR__ . '/../Storage/cache/views';     // Pasta de cache (para otimizar a renderização)

$blade = new Blade($views, $cache);

// Função para renderizar uma view Blade
function View($view, $data = [])
{
    global $blade;
    echo $blade->make($view, $data)->render();  // Renderiza a view e exibe
}


function renderView($view, $data = [])
{
    global $blade;

    // Verifica se o arquivo de view existe
    $viewPath = __DIR__ . '/../Resources/Views/' . Str::snake($view) . '.blade.php';
    if (file_exists($viewPath)) {
        // Renderiza a view Blade com os dados
        echo $blade->make($view, $data)->render();
    } else {
        throw new Exception("View {$view} não encontrada.");
    }
}
