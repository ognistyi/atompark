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
        $configPath = __DIR__ . "/../../config/atom_park.php";

        $this->publishes(
            [$configPath => $this->configPath("atom_park.php")],
            "config"
        );

        $this->mergeConfigFrom($configPath, "atom_park");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('AtomPark', function ($app) {
            return new AtomParkApi(config('atom_park.login'), config('atom_park.password'), config('atom_park.endpoint'));
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
            'AtomPark'
        ];
    }

    protected function configPath(string $path = "") : string
    {
        if (function_exists("config_path")) {
            return config_path($path);
        }
        $pathParts = [
            app()->basePath(),
            "config",
            trim($path, "/"),
        ];
        return implode("/", $pathParts);
    }
}