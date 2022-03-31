<?php

namespace Porygon\Organization;

use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/config.php',
            'jorganization'
        );
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__ . "/Admin/bootstrap.php";
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('jorganization.php'),
        ], "jorganization-config");
        $this->publishes([
            __DIR__ . "/../database/migrations" => database_path("migrations")
        ], "jorganization-migration");
    }
}
