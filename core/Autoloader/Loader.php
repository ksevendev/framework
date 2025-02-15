<?php
namespace Core\Autoloader;

class Loader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'load']);
    }

    public static function load($class, ?string $base_dir, ?string $prefix)
    {
        $prefix = $prefix ?? 'KSeven\\';
        $base_dir = $base_dir ?? __DIR__ . '/../../app/';
        
        // Verifica se a classe pertence ao namespace do framework
        if (strpos($class, $prefix) === 0) {
            $relative_class = substr($class, strlen($prefix));
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
            if (file_exists($file)) {
                require $file;
            }
        }
    }
}
