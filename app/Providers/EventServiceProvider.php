<?php

namespace App\Providers;

use Event;
use Illuminate\Database\Events\StatementPrepared;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        # 設定資料提取類型
        Event::listen(StatementPrepared::class, function ($event) {
            $event->statement->setFetchMode(config('database.fetch'));
        });
    }

    public function register()
    {
        //
    }
}