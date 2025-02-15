<?php

use Jenssegers\Blade\Blade;
use Illuminate\Support\Str;

// Função para carregar e renderizar componentes
function Component($componentName, $data = [])
{
    global $blade;

    // Checa se o componente existe na pasta de componentes
    $componentPath = __DIR__ . '/../Resources/Views/components/' . Str::snake($componentName) . '.blade.php';

    if (file_exists($componentPath)) {
        // Renderiza o componente Blade com os dados
        return $blade->make('components.' . Str::snake($componentName), $data)->render();
    }

    throw new Exception("Componente {$componentName} não encontrado.");
}
