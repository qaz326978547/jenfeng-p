<?php

namespace App\Controller;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrationsController
{
    protected $key = 'adqwsafdsgwegfsdgsdgsdfsdfsdfsfs';

    /**
     * 資料庫遷移處理
     *
     * key 請隨意設置一個不會被猜到的英文數字組合 總之就是不會被別人啟動他
     * 傳到線上後 就在網址列上 輸入  /migrations/設定的key 就能對資料庫進行操作
     *
     * @example https://laravel-china.org/docs/laravel/5.6/migrations
     */
    public function up($key)
    {
        if ($key != $this->key) {
            return redirect('index')->withErrors('非法操作')->send();
        }

        Schema::table('product', function (Blueprint $table) {
            $table->tinyInteger('p_test');
        });
    }

    /**
     * 還原用
     *
     * 如果擔心一次操作之後會有問題 那就花點時間寫原本的狀態
     */
    public function down($key)
    {
        if ($key != $this->key) {
            return redirect('index')->withErrors('非法操作')->send();
        }

        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn('p_test');
        });
    }

    /**
     * 檢查用
     *
     */
    public function check($key)
    {
        if ($key != $this->key) {
            return redirect('index')->withErrors('非法操作')->send();
        }

        dump(Schema::getColumnListing('product'));
        dump(Schema::getColumnType('product', 'free_shipping'));
    }
}