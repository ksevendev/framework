<?php

namespace App;

use App\Application AS App;
use Illuminate\Contracts\Foundation\Application;

class Kernel
{

    protected App $app;

    protected array $providers = [
        \App\Providers\AppServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
    ];


    public function __construct(?App $app)
    {
        $this->app = $app ?? new App;
    }

    public function bootstrap()
    {
        // Carregar configurações e providers
        //$this->app->make('db'); // Inicializa o banco de dados
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
