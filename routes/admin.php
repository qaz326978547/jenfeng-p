<?php

// 路由 - 只接受三個參數 0 => Http Method , 2 => 控制器@方法 , 3 => 中介層 (陣列 可多個)
// 路由路徑 - 帶入控制器方法的參數 請務必用 {} 包起來, 以搜尋 " /{ " 來判斷後面的全都是參數

return [
	// 登入/登出
	['admin'        => ['get', 'Admin\LoginController@index', ['admin.guest'] ] ],
	['admin'        => ['post', 'Admin\LoginController@login', ['admin.guest'] ] ],
	['admin/logout' => ['get', 'Admin\LoginController@logout'] ],

	// 首頁
	['admin/index' => ['get', 'Admin\IndexController@index', ['admin'] ] ],

	// 帳號管理
	['admin/account/upd_pw/{id}' => ['get', 'Admin\AccountController@show_upd_pw', ['admin'] ] ],
	['admin/account/upd_pw/{id}'  => ['patch', 'Admin\AccountController@upd_pw', ['admin'] ] ],

	// HTML 編輯器
	['admin/html-editor/manager'            => ['get', 'Admin\HtmlEditorManagerController@show', ['admin'] ] ],
	['admin/html-editor/manager/{class_id}' => ['get', 'Admin\HtmlEditorManagerController@show', ['admin'] ] ],
	['admin/html-editor/{class_id}/{id}'    => ['post', 'Admin\HtmlEditorManagerController@add', ['admin'] ] ],
	['admin/html-editor/{class_id}/{id}'    => ['patch', 'Admin\HtmlEditorManagerController@upd', ['admin'] ] ],
	['admin/html-editor/{class_id}/{id}'    => ['delete', 'Admin\HtmlEditorManagerController@del', ['admin'] ] ],
		# 上傳圖片
	['admin/html-editor/image-upload'       => ['post', 'Admin\HtmlEditorManagerController@single_image_upload', ['admin'] ] ],
		# 多圖
	['admin/html-editor/ajax/pics/{pid}' => ['get', 'Admin\HtmlEditorManagerController@ajax_pics_get'] ],
	['admin/html-editor/ajax/pics/{pid}' => ['post', 'Admin\HtmlEditorManagerController@ajax_pics_upload'] ],
	['admin/html-editor/ajax/pics/{pid}/{id}/{column}' => ['patch', 'Admin\HtmlEditorManagerController@ajax_pics_upd'] ],
	['admin/html-editor/ajax/pics/{pid}/{id}' => ['delete', 'Admin\HtmlEditorManagerController@ajax_pics_del'] ],

	// 簡易設定
	['admin/simple_setting'      => ['get', 'Admin\SimpleSettingController@index', ['admin'] ] ],
	['admin/simple_setting/{id}' => ['get', 'Admin\SimpleSettingController@edit', ['admin'] ] ],
	['admin/simple_setting/{id}' => ['post', 'Admin\SimpleSettingController@add', ['admin'] ] ],
	['admin/simple_setting/{id}' => ['patch', 'Admin\SimpleSettingController@upd', ['admin'] ] ],
	['admin/simple_setting/{id}' => ['delete', 'Admin\SimpleSettingController@del', ['admin'] ] ],
	['admin/simple_setting/ajax/upd/{id}/{column}' => ['patch', 'Admin\SimpleSettingController@ajax_upd'] ],
	['admin/simple_setting/upd_line_notify' => ['get', 'Admin\SimpleSettingController@show_upd_line_notify', ['admin'] ] ],

	// Page (開發用)
	['admin/page'      => ['get', 'Admin\PageController@index', ['admin'] ] ],
	['admin/page/{id}' => ['get', 'Admin\PageController@edit', ['admin'] ] ],
	['admin/page/{id}' => ['post', 'Admin\PageController@add', ['admin'] ] ],
	['admin/page/{id}' => ['patch', 'Admin\PageController@upd', ['admin'] ] ],
	['admin/page/{id}' => ['delete', 'Admin\PageController@del', ['admin'] ] ],
		# 多圖
	['admin/page/ajax/pics/{pid}' => ['get', 'Admin\PageController@ajax_pics_get'] ],
	['admin/page/ajax/pics/{pid}' => ['post', 'Admin\PageController@ajax_pics_upload'] ],
	['admin/page/ajax/pics/{pid}/{id}/{column}' => ['patch', 'Admin\PageController@ajax_pics_upd'] ],
	['admin/page/ajax/pics/{pid}/{id}' => ['delete', 'Admin\PageController@ajax_pics_del'] ],
		# 多檔
	['admin/page/ajax/files/{pid}' => ['get', 'Admin\PageController@ajax_files_get'] ],
	['admin/page/ajax/files/{pid}' => ['post', 'Admin\PageController@ajax_files_upload'] ],
	['admin/page/ajax/files/{pid}/{id}/{column}' => ['patch', 'Admin\PageController@ajax_files_upd'] ],
	['admin/page/ajax/files/{pid}/{id}' => ['delete', 'Admin\PageController@ajax_files_del'] ],

	// 瀏覽
	['admin/browse'      => ['get', 'Admin\BrowseController@index', ['admin'] ] ],
	['admin/browse/{id}' => ['get', 'Admin\BrowseController@edit', ['admin'] ] ],
	['admin/browse/{id}' => ['post', 'Admin\BrowseController@add', ['admin'] ] ],
	['admin/browse/{id}' => ['patch', 'Admin\BrowseController@upd', ['admin'] ] ],
	['admin/browse/{id}' => ['delete', 'Admin\BrowseController@del', ['admin'] ] ],
	['admin/browse/ajax/upd/{id}/{column}' => ['patch', 'Admin\BrowseController@ajax_upd'] ],
	['admin/browse/today-data' => ['get', 'Admin\BrowseController@show_today_data', ['admin'] ] ],

	// SEO
		# 分類
	['admin/seo_class/{class_id}'      => ['get', 'Admin\SeoClassController@index', ['admin'] ] ],
	['admin/seo_class/{class_id}/{id}' => ['get', 'Admin\SeoClassController@edit', ['admin'] ] ],
	['admin/seo_class/{class_id}/{id}' => ['post', 'Admin\SeoClassController@add', ['admin'] ] ],
	['admin/seo_class/{class_id}/{id}' => ['patch', 'Admin\SeoClassController@upd', ['admin'] ] ],
	['admin/seo_class/{class_id}/{id}' => ['delete', 'Admin\SeoClassController@del', ['admin'] ] ],
	['admin/seo_class/ajax/upd/{id}/{column}' => ['patch', 'Admin\SeoClassController@ajax_upd'] ],
		# 商品
	['admin/seo/{class_id}'      => ['get', 'Admin\SeoController@index', ['admin'] ] ],
	['admin/seo/{class_id}/{id}' => ['get', 'Admin\SeoController@edit', ['admin'] ] ],
	['admin/seo/{class_id}/{id}' => ['post', 'Admin\SeoController@add', ['admin'] ] ],
	['admin/seo/{class_id}/{id}' => ['patch', 'Admin\SeoController@upd', ['admin'] ] ],
	['admin/seo/{class_id}/{id}' => ['delete', 'Admin\SeoController@del', ['admin'] ] ],

	// Banner
	['admin/banner'      => ['get', 'Admin\BannerController@index', ['admin'] ] ],
	['admin/banner/{id}' => ['get', 'Admin\BannerController@edit', ['admin'] ] ],
	['admin/banner/{id}' => ['post', 'Admin\BannerController@add', ['admin'] ] ],
	['admin/banner/{id}' => ['patch', 'Admin\BannerController@upd', ['admin'] ] ],
	['admin/banner/{id}' => ['delete', 'Admin\BannerController@del', ['admin'] ] ],
	['admin/banner/ajax/upd/{id}/{column}' => ['patch', 'Admin\BannerController@ajax_upd'] ],

	// FAQ
		# 分類
	['admin/faq_class/{class_id}'      => ['get', 'Admin\FaqClassController@index', ['admin'] ] ],
	['admin/faq_class/{class_id}/{id}' => ['get', 'Admin\FaqClassController@edit', ['admin'] ] ],
	['admin/faq_class/{class_id}/{id}' => ['post', 'Admin\FaqClassController@add', ['admin'] ] ],
	['admin/faq_class/{class_id}/{id}' => ['patch', 'Admin\FaqClassController@upd', ['admin'] ] ],
	['admin/faq_class/{class_id}/{id}' => ['delete', 'Admin\FaqClassController@del', ['admin'] ] ],
	['admin/faq_class/ajax/upd/{id}/{column}' => ['patch', 'Admin\FaqClassController@ajax_upd'] ],
		# 商品
	['admin/faq'      => ['get', 'Admin\FaqController@index', ['admin'] ] ],
	['admin/faq/{id}' => ['get', 'Admin\FaqController@edit', ['admin'] ] ],
	['admin/faq/{id}' => ['post', 'Admin\FaqController@add', ['admin'] ] ],
	['admin/faq/{id}' => ['patch', 'Admin\FaqController@upd', ['admin'] ] ],
	['admin/faq/{id}' => ['delete', 'Admin\FaqController@del', ['admin'] ] ],
	['admin/faq/ajax/upd/{id}/{column}' => ['patch', 'Admin\FaqController@ajax_upd'] ],
	 
  
	// 聯絡我們
	['admin/contact'      => ['get', 'Admin\ContactController@index', ['admin'] ] ],
	['admin/contact/{id}' => ['get', 'Admin\ContactController@edit', ['admin'] ] ],
	// ['admin/contact/{id}' => ['post', 'Admin\ContactController@add', ['admin'] ] ],
	['admin/contact/{id}' => ['patch', 'Admin\ContactController@upd', ['admin'] ] ],
	['admin/contact/{id}' => ['delete', 'Admin\ContactController@del', ['admin'] ] ],
	['admin/contact/excel/{action}' => ['any', 'Admin\ContactController@excel', ['admin'] ] ],

	// 聯絡我們 課程
	['admin/contact_class'      => ['get', 'Admin\ContactClassController@index', ['admin'] ] ],
	['admin/contact_class/{id}' => ['get', 'Admin\ContactClassController@edit', ['admin'] ] ],
	['admin/contact_class/{id}' => ['post', 'Admin\ContactClassController@add', ['admin'] ] ],
	['admin/contact_class/{id}' => ['patch', 'Admin\ContactClassController@upd', ['admin'] ] ],
	['admin/contact_class/{id}' => ['delete', 'Admin\ContactClassController@del', ['admin'] ] ],
	['admin/contact_class/ajax/upd/{id}/{column}' => ['patch', 'Admin\ContactClassController@ajax_upd'] ],

	// 聯絡我們 問題
	['admin/contact_quest'      => ['get', 'Admin\ContactQuestController@index', ['admin'] ] ],
	['admin/contact_quest/{id}' => ['get', 'Admin\ContactQuestController@edit', ['admin'] ] ],
	['admin/contact_quest/{id}' => ['post', 'Admin\ContactQuestController@add', ['admin'] ] ],
	['admin/contact_quest/{id}' => ['patch', 'Admin\ContactQuestController@upd', ['admin'] ] ],
	['admin/contact_quest/{id}' => ['delete', 'Admin\ContactQuestController@del', ['admin'] ] ],
	['admin/contact_quest/ajax/upd/{id}/{column}' => ['patch', 'Admin\ContactQuestController@ajax_upd'] ],	
];