<?php
namespace Core\Autoloader;

class Loader
{
    
    /**
     * Carrega automaticamente bibliotecas e módulos de terceiros.
     */
    public function loadThirdPartyLibraries()
    {
        $thirdPartyPath = __DIR__ . '/../../app/ThirdParty';
        if (is_dir($thirdPartyPath)) {
            foreach (glob($thirdPartyPath . '/*', GLOB_ONLYDIR) as $libraryDir) {
                $this->registerLibraryAutoloader($libraryDir);
            }
        }
    }

    /**
     * Carrega automaticamente os módulos personalizados.
     */
    public function loadModules()
    {
        $modulesPath = __DIR__ . '/../../Modules';
        if (is_dir($modulesPath)) {
            foreach (glob($modulesPath . '/*', GLOB_ONLYDIR) as $moduleDir) {
                $this->registerModuleAutoloader($moduleDir);
            }
        }
    }

    /**
     * Registra o autoloader para uma biblioteca de terceiros.
     */
    private function registerLibraryAutoloader(string $libraryDir)
    {
        spl_autoload_register(function ($class) use ($libraryDir) {
            $classFile = $libraryDir . '/src/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($classFile)) {
                require $classFile;
            }
        });
    }

    /**
     * Registra o autoloader para um módulo.
     */
    private function registerModuleAutoloader(string $moduleDir)
    {
        spl_autoload_register(function ($class) use ($moduleDir) {
            $classFile = $moduleDir . '/Controllers/' . str_replace('\\', '/', $class) . '.php';
            if (file_exists($classFile)) {
                require $classFile;
            }
        });
    }
}
