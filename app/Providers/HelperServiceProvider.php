<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach (glob(__DIR__ . '/../../app/Helpers/*.php') as $filename) {
            require_once $filename;
        }

        foreach (glob(__DIR__ . '/../../app/Helpers/AhWei/*.php') as $filename) {
            require_once $filename;
        }

        foreach (glob(__DIR__ . '/../../app/Helpers/Dennis/*.php') as $filename) {
            require_once $filename;
        }

        foreach (glob(__DIR__ . '/../../app/Helpers/Kay/*.php') as $filename) {
            require_once $filename;
        }
    }
}