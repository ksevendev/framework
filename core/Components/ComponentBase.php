<?php

namespace Core\Components;

use Illuminate\Support\Facades\File;

class ComponentBase
{
    protected $components = [];

    /**
     * Registrar um componente.
     *
     * @param string $name
     * @param string $path
     * @return void
     */
    public function registerComponent($name, $path)
    {
        $this->components[$name] = $path;
    }

    /**
     * Renderizar um componente.
     *
     * @param string $name
     * @param array $data
     * @return string
     */
    public function renderComponent($name, $data = [])
    {
        if (isset($this->components[$name])) {
            $componentPath = $this->components[$name];

            if (File::exists($componentPath)) {
                // Se o componente existir, podemos carregar o arquivo de componente e fazer a renderização
                ob_start();
                extract($data);
                require $componentPath;
                return ob_get_clean();
            }
        }

        throw new \Exception("Componente {$name} não encontrado.");
    }

    /**
     * Carregar todos os componentes da pasta de componentes.
     *
     * @return void
     */
    public function loadComponentsFromDirectory()
    {
        $files = File::allFiles(__DIR__ . '/../../resources/views/components');

        foreach ($files as $file) {
            $name = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $this->registerComponent($name, $file->getRealPath());
        }
    }
}
