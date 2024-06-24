<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

/**
 * Blade
 * @example https://laravel-china.org/docs/laravel/5.6/blade
 */
class BladeServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // include
        Blade::include('admin.includes.style', 'adminStyle');   // 後台 style
        Blade::include('admin.includes.script', 'adminScript'); // 後台 script

    	// component
    	Blade::aliasComponent('admin.components.left', 'adminLeft');			// 後台左列表
    	Blade::aliasComponent('admin.components.paginate', 'adminPaginate');	// 後台分頁
    	Blade::aliasComponent('admin.components.edit_row', 'adminRow');		// 後台編輯 row
    }

    public function register()
    {
        //
    }
}