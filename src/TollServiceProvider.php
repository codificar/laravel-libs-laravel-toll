<?php

namespace Codificar\Toll;

use Illuminate\Support\ServiceProvider;

class TollServiceProvider extends ServiceProvider 
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Load blade templates
        $this->loadViewsFrom(__DIR__.'/resources/views', 'toll');

        // Load trans files
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'toll');

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $this->publishes([
            __DIR__.'/Database/seeders' => database_path('seeders')
        ], 'public_vuejs_libs');

        $this->publishes([
            __DIR__.'/../public/js' => public_path('vendor/codificar/toll/js'),
        ], 'public_vuejs_libs');
    }

    public function register()
    {

    }
}