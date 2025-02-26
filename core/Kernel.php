<?php

namespace Core;

use Core\Application as App;
use Core\Autoloader\Loader;
use Core\Debug\Toolbar;
use Core\View\View;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

class Kernel
{
    
    public $core;

    protected $app;

    protected $capsule;

    protected $toolbar;

    protected array $providers = [
        // Adicione seus provedores de serviço aqui
        // \Core\Providers\AppServiceProvider::class,
        // \Core\Providers\RouteServiceProvider::class,
        // \Core\Providers\ViewServiceProvider::class,
    ];

    public function __construct(?App $app = null, ?Capsule $capsule = null)
    {
        $this->core = new Container;
        $this->app = $app ?? new App;
        $this->capsule = $capsule ?? new Capsule;
        $this->loadConfig();
        $this->toolbar = new Toolbar(); // Cria a instância da toolbar
        $debug = env("APP_DEBUG");//$this->getConfig('config.env', 'production');
        if ($debug !== 'production') {
            $this->toolbar->render(); // Exibe a toolbar
        }

    }

    public function bootstrap()
    {

        $autoLoader = new Loader();
        $autoLoader->loadThirdPartyLibraries();
        $autoLoader->loadModules();

        $groupConnection = $this->getConfig('database.group', 'default');
        $dbConfig = $this->getConfig("database.connections.default", []);

        if (!empty($dbConfig) && isset($dbConfig['driver'])) {
            $this->capsule->addConnection($dbConfig, $groupConnection);
        }

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();

        Container::setInstance($this->core);
        $this->core->instance('db', $this->capsule);

        $template_enabled = $this->getConfig('template.enabled', false);
        if ($template_enabled) {
            $template_path = __DIR__ . '/../templates';
        } else {
            $template_path = __DIR__ . '/../resources/views';
        }

        // Configuração do Blade
        $view = new View(
            $template_path, 
            __DIR__ . '/../storage/cache/views',
            View::MODE_DEBUG,
            0
        );
        
        $this->app->instance('view', $view); // Registra no container com nome "view"
        $this->app->instance(View::class, $view); // Registra com o nome da classe

        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
    
    public function getContainer(): \Illuminate\Container\Container
    {
        return $this->core;
    }

    protected function loadConfig()
    {
        $configurations = [];

        foreach (glob(__DIR__ . '/../app/Config/*.php') as $file) {
            $name = strtolower(basename($file, '.php'));
            $configurations[$name] = require $file;
        }

        $this->core->instance('config', $configurations);
    }

    public function getConfig(string $key, $default = null)
    {
        $config = $this->core->make('config');
        $keys = explode('.', strtolower($key));
        $value = $config;

        foreach ($keys as $segment) {
            if (!isset($value[$segment])) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

}
