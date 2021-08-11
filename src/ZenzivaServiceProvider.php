<?php

namespace Kevinpurwito\LaravelZenziva;

use Illuminate\Support\ServiceProvider;

class ZenzivaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->offerPublishing();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/kp_zenziva.php', 'kp_zenziva');

        $this->app->singleton('Zenziva', function () {
            return new Zenziva(
                config('kp_zenziva.userkey'),
                config('kp_zenziva.passkey'),
                config('kp_zenziva.type')
            );
        });
    }

    protected function offerPublishing()
    {
        if (! function_exists('config_path')) {
            // function not available and 'publish' not relevant in Lumen
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/kp_zenziva.php' => config_path('kp_zenziva.php'),
        ], 'zenziva');
    }
}
