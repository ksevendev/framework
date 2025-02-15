<?php

namespace App;

use App\Application; // Mudança importante: Use Core\Application
use Core\Kernel as CoreKernel;

use Illuminate\Database\Capsule\Manager as Capsule;

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
        $this->capsule = $capsule ?? new Capsule;
        parent::__construct($this->app, $this->capsule);
    }

}
