<?php

namespace App;

use Core\Application; // Mudança importante: Use Core\Application
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
        $this->app = $app ?? new Application();
        parent::__construct($this->app);
    }
}
