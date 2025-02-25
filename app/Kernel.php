<?php

namespace App;

use App\Application; // Mudança importante: Use Core\Application
use Core\Kernel as CoreKernel;

class Kernel extends CoreKernel
{
    protected $app; // Agora o tipo é compatível

    protected array $providers = [
        \App\Providers\AppServiceProvider::class,
        \App\Providers\RouteServiceProvider::class,
    ];

    public function __construct(?Application $app)
    {
        $this->app = $app;
        //parent::__construct($this->app, $this->capsule);
    }

}
