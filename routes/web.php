<?php

// 路由 - 只接受三個參數 0 => Http Method , 2 => 控制器@方法 , 3 => 中介層 (陣列 可多個)
// 路由路徑 - 帶入控制器方法的參數 請務必用 {} 包起來, 以搜尋 " /{ " 來判斷後面的全都是參數

return [
	// 工具
		# 驗證器
	['tool-ajax-validate' => ['any', 'ToolController@ajax_validate'] ],
		# 暫存輸入資料
	['tool-ajax-temp-input' => ['any', 'ToolController@ajax_temp_input'] ],
		# 驗證碼
	['tool-captcha'       => ['get', 'ToolController@captcha'] ],
	 	# 檔案下載
	['tool-download/{table}/{column}/{id}' => ['get', 'ToolController@download'] ],
	['tool-download/{table}/{column}/{id}/{inline_name}' => ['get', 'ToolController@download'] ],

	// 圖片編輯器
	['image-editor/{image_url}' => ['get', 'ImageEditorController@index'] ],
	['image-editor/save'        => ['post', 'ImageEditorController@save'] ],

	// 資料庫遷移
	['migrations/up/{key}'    => ['get', 'MigrationsController@up'] ],
	['migrations/down/{key}'  => ['get', 'MigrationsController@down'] ],
	['migrations/check/{key}' => ['get', 'MigrationsController@check'] ],

	// 工作排程
	['cron/{name}' => ['get', 'CronJobController@job'] ],

	// sitemap
	['sitemap' => ['get', 'Web\SitemapController@process'] ],

	// 首頁
	['/'     => ['get', 'Web\IndexController@index'] ],
	['index' => ['get', 'Web\IndexController@index'] ],

	// 最新消息
	// ['news'      => ['get', 'Web\NewsController@index'] ],
	// ['news/{id}' => ['get', 'Web\NewsController@detail'] ],

 	// 產品
	// ['product'                         => ['get', 'Web\ProductController@index'] ],
	// ['product/{level_1_class_id}'      => ['get', 'Web\ProductController@index'] ],
	// ['product/{level_1_class_id}/{id}' => ['get', 'Web\ProductController@detail'] ],

	// 聯絡我們
	// ['contact' => ['get', 'Web\ContactController@index'] ],
	['contact' => ['post', 'Web\ContactController@add'] ],
];