<?php

namespace App;

use Illuminate\Contracts\Foundation\Application AS App;
use Illuminate\Container\Container;

class Application extends Container //implements App
{
    public function register($provider)
    {
        $instance = new $provider($this);
        $instance->register();
    }
}
