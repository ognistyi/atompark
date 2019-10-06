<?php

namespace Ognistyi\AtomPark\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Ognistyi\AtomPark\AtomParkApi;

class AtomParkServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [__DIR__ . '/../config/atom_park.php' => config_path('atom_park.php')]
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AtomParkApi::class, function ($app) {
            return new AtomParkApi(config('atom_park'));
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            AtomParkApi::class
        ];
    }
}