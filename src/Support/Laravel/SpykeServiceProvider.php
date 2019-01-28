<?php

namespace Blaze\Spyke\Support\Laravel;

use Blaze\Spyke\OmdbApi;
use Illuminate\Support\ServiceProvider;

class SpykeServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->makeConfig();
    }
    
    protected function makeConfig()
    {
        $config_path = dirname(__DIR__) . '/config.php';
        $this->publishes([$config_path => config_path('spyke.php')], 'Myst');
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config.php', 'spyke');

        $this->app->singleton('Blaze\Spyke\OmdbApi', function () {
            $config = config('spyke');
            return new OmdbApi($config);
        });
    }
}
