<?php

namespace App\Providers;

use App\Application;
use App\Providers\ServiceProvider;
use Illuminate\Database\Capsule\Manager as Capsule;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        
        /*
        // Configuração do banco de dados com Eloquent
        $this->app->singleton('db', function () {
            $capsule = new Capsule;
            $capsule->addConnection([
                'driver' => $_ENV['DB_DRIVER'],
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_DATABASE'],
                'username' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        });
        */

        $this->app->singleton('files', function () {
            return new Filesystem();
        });

        $this->app->singleton('filesystem', function ($app) {
            return new FilesystemManager($app);
        });
    }
}

