<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

/**
 * View
 * @example https://laravel-china.org/docs/laravel/5.6/views
 */
class ViewServiceProvider extends ServiceProvider
{

    public function boot()
    {
        // 不使用 composer [web.*] 的做法
        if(\Request::ajax() === false) {
            if (!\Str::contains(\Request::path(), 'admin')) {
                # (前台) 所有 View 共享數據 (只會和DB溝通一次)
                // $test = 'test';

                // View::share('test', $test);
            } else {
                # (後台) 所有 View 共享數據 (只會和DB溝通一次)
            }
        }

        // ------ web layout ------
        // View::composer('web.includes.layout', function ($view) {

        //     $view->with(compact(''));
        // });

        // ------ web head ------
        // View::composer('web.includes.head', function ($view) {

        //     $view->with(compact(''));
        // });

        // ------ web header ------
        // View::composer('web.includes.header', function ($view) {

        //     $view->with(compact(''));
        // });

        // ------ web footer ------
        // View::composer('web.includes.footer', function ($view) {

        //     $view->with(compact(''));
        // });

        // ------ Page ------ (哪裡需要就擴充陣列)
        View::composer(['web.*'], function ($view) {

            $pages = \DB::table(config('page.table'))
                        ->get()
                        ->groupBy('path')
                        ->transform(function($row, $key) {
                            return $row->keyBy('id');
                        });

            if(\Str::contains($view->getName(), [''])) {
                $pages_pics = \DB::table(config('page.pics_table'))->where([['del', 0]])->orderBy('no', 'desc')->orderBy('id', 'asc')->get()->groupBy('pid');
                // $pages_files = \DB::table(config('page.files_table'))->where([['del', 0]])->orderBy('no', 'desc')->orderBy('id', 'asc')->get()->groupBy('pid');
            }

            $view->with(compact('pages'));
        });

        // ------ Seo ------ (哪裡需要就擴充陣列)
        View::composer(['web.*'], function ($view) {

            $seo_data = \DB::table(config('seo.table'))
            		  ->get()
            		  ->groupBy('tag')
            		  ->transform(function($row, $key) {
                    		return $row->keyBy('id');
                      });

            $view->with(compact('seo_data'));
        });

        // ------ view admin 底下共用 ------
        // View::composer('admin.*', function ($view) {

        //     $view->with(compact(''));
        // });
    }

    public function register()
    {
        //
    }
}