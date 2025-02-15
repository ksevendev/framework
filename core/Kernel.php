<?php

namespace Core;

use Core\Application as App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

class Kernel
{
    protected $core;
    protected $app;
    protected $capsule;

    protected array $providers = [
        // Add your service providers here
        // \Core\Providers\AppServiceProvider::class,
        // \Core\Providers\RouteServiceProvider::class,
    ];

    public function __construct(?App $app = null, ?Capsule $capsule = null)
    {
        $this->core = new Container;
        $this->app = $app ?? new App;
        $this->capsule = $capsule ?? new Capsule;
        $this->loadConfig();
    }

    /**
     * Load all configurations from the config directory
     */
    protected function loadConfig()
    {
        $configurations = [];
    
        // Carregar configurações da pasta app/Config/
        foreach (glob(__DIR__ . '/../app/Config/*.php') as $file) {
            $name = strtolower(basename($file, '.php')); // Normaliza para minúsculas
            $configurations[$name] = require $file;
        }
    
        // Armazena as configurações no Container
        $this->core->instance('config', $configurations);
    }    

    /**
     * Get configuration by key in the format 'database.connections.mysql'
     */
    public function getConfig(string $key, $default = null)
    {
        $config = $this->core->make('config');
        $keys = explode('.', strtolower($key)); // Normalize to lowercase
        $value = $config;

        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Bootstrap the framework and configure core services
     */
    public function bootstrap()
    {
        // Carrega o .env antes de qualquer configuração
        new \Core\Config\BaseConfig();

        // Get the group connection configuration from the config
        $groupConnection = $this->getConfig('database.group', 'default');
        $dbConfig = $this->getConfig("database.connections.default", []);

        if (!empty($dbConfig) && isset($dbConfig['driver'])) {
            // Add the database connection to Capsule
            $this->capsule->addConnection($dbConfig, $groupConnection);
        }

        // Initialize Eloquent ORM
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        // Set the main container instance
        Container::setInstance($this->core);

        // Register instances in the container
        $this->core->instance('db', $this->capsule);

        // Initialize Service Providers
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
