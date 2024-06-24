<?php

namespace App\Controller\Admin;

class IndexController
{
    /**
     * 首頁
     */
    public function index()
    {
    	# 帳號資訊
    	$admin = \DB::table('admin')->where('id', \Session::get('admuser') )->first();
    	
    	# 編輯器圖片
    	$editor_pic = \DB::table(config('html_editor_manager_admin.pics_table'))->where('del', 0 )->count();

		# 瀏覽記錄
		$browse_record = [
			'all' => \DB::table(config('browse.record_table'))->sum('num'),
			'today' => \DB::table(config('browse.record_table'))
						  ->where([['date', \Date::now()->toDateString()]])
						  ->value('num'),
		];

    // 	Base
    	$count_data = [];

    	foreach (['contact'] as $key => $value) {
    		array_push($count_data, [
    			'title' => config($value . '.page_title'),
    			'num' => \DB::table(config($value . '.table'))->where([['del', 0]])->count(),
    		]);
    	}

    // Order
    	$order_count_data = [];

    	// foreach (config('order.process') as $key => $value) {
    	// 	array_push($order_count_data, [
    	// 		'title' => $value,
    	// 		'num' => \DB::table(config('order.table'))->where([['del', 0], ['process' , $key]])->count(),
    	// 	]);
    	// }    		
    	
        $view = \View::make('admin.index' , compact('admin', 'editor_pic', 'browse_record', 'count_data', 'order_count_data'))->render();

        return \Response::create($view)->send();
    }
}