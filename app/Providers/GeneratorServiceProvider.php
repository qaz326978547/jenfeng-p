<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ClassMap\AdminMakeCommand;
// use App\ClassMap\MakeRepositoryCommand;
// use App\ClassMap\MakeModelCommand;
// use App\ClassMap\MakeMigrationCommand;
// use App\ClassMap\MakeServiceCommand;
// use App\ClassMap\MakeControllerCommand;
// use App\ClassMap\MakeRouteCommand;
// use App\ClassMap\MakeConfigCommand;
// use App\ClassMap\MakeViewCommand;
// use App\ClassMap\MakeJsCommand;

class GeneratorServiceProvider extends ServiceProvider
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
        if (config('system.env') == 'local') {
	        $this->commands([
	        	AdminMakeCommand::class,
	        ]);
		}
    }
}
