<?php

// 多語言判斷
if (Request::ajax() === false) {
	if (\Str::contains(Request::path(), 'admin')) {
		$suffix = BACK_DB_LANG;
	} else {
		$suffix = DB_LANG;
	}
} else {
	if (\Str::contains(Session::get('previous_url'), 'admin')) {
		$suffix = BACK_DB_LANG;
	} else {
		$suffix = DB_LANG;
	}
}

$table = 'faq' . $suffix;

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$file_max_limit = 1024 * 20; 	// 單檔大小限制 (單位:KB)
$file_mime      = 'pdf';		// 單檔MIME類型

$p_home_name = '首頁上架';    // 首頁 欄位名稱
$p_new_name  = '最新商品';    // 最新 欄位名稱
$p_run_name  = '特價區';  	  // 特價 欄位名稱
$p_hot_name  = '人氣排行';    // 熱門 欄位名稱
$p_home_num = 1;	// 首頁 顯示筆數，依照勾選順序,不限制時輸入0
$p_new_num  = 1;	// 最新 顯示筆數，依照勾選順序,不限制時輸入0
$p_run_num  = 1;	// 特價 顯示筆數，依照勾選順序,不限制時輸入0
$p_hot_num  = 1;	// 熱門 顯示筆數，依照勾選順序,不限制時輸入0
$act_num = 0;

return [
	'config'      => 'faq',
	'folder'      => 'faq',
	'link_tag'    => 'faq',

	'table'       => $table,
	'class_table' => $table.'_class',	// 類別資料表
	'pics_table'  => $table.'_pics', 	// 多圖資料表
	'files_table' => $table.'_files', 	// 多檔資料表

	'page_title' => 'FAQ' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'  => 10,				 	// 資料每頁顯示比數

	//---------  圖片 ---------
	'pic_set'       => 0,                // 單圖上傳
	'pic_edit'      => 0,
	'pic_width'     => 1920,
	'pic_height'    => 1920,
	'pic_max_limit' => $pic_max_limit,	 // 單圖大小限制 (單位:KB)
	'pic_mime'      => $pic_mime,		 // 單圖MIME類型

	'multpic_set'       => 0,            // 額外圖片(大量上傳)
	'multpic_edit'      => 0,
	'multpic_width'     => 1920,		 // 多圖寬度
	'multpic_height'    => 1920,		 // 多圖高度
	'multpic_max_limit' => 1024 * 2,	 // 多圖大小限制 (單位:KB)
	'multpic_num_limit' => 0,	 		 // 多圖數量限制
	'multpic_mime'      => 'jpeg,png',	 // 多圖MIME類型

	//--------- 檔案 ---------
	'file_set'       => 0,					// 單檔上傳
	'file_max_limit' => $file_max_limit,
	'file_mime'      => $file_mime,			// 單檔MIME類型

	'multfile_set'       => 0,           	// 多檔上傳
	'multfile_max_limit' => 1024 * 20,		// 多檔大小限制 (單位:KB)
	'multfile_mime'      => 'pdf',			// 多檔MIME類型

	//--------- youtube 影片嵌入 --------
	'utube_set' => 0,

	//--------- ckeckbox (首頁上架、最新、特價、熱門) ---------
	'p_checkbox_have' => ['p_home', 'p_new', 'p_run', 'p_hot'],	// 方便一次改全部相關的程式碼

	'p_home_set'   => 0,                	// 首頁 顯示啟用
	'p_home_num'   => $p_home_num,          // 顯示筆數，依照勾選順序,不限制時輸入0
	'p_home_name'  => $p_home_name,       	// 顯示 名稱

	'p_new_set'    => 0,                	// 最新 顯示啟用
	'p_new_num'    => $p_new_num,           // 顯示筆數，依照勾選順序,不限制時輸入0
	'p_new_name'   => $p_new_name,       	// 顯示名稱

	'p_run_set'    => 0,                	// 特價 顯示啟用
	'p_run_num'    => $p_run_num,           // 顯示筆數，依照勾選順序,不限制時輸入0
	'p_run_name'   => $p_run_name,       	// 顯示名稱

	'p_hot_set'    => 0,                	// 熱門 顯示啟用
	'p_hot_num'    => $p_hot_num,           // 顯示筆數，依照勾選順序,不限制時輸入0
	'p_hot_name'   => $p_hot_name,       	// 顯示名稱

	'act_num' => $act_num,

	//--------- 模組  ---------

	//--------- 欄位 ---------
	'no_set'       => 1,				// 排序
	'date_set'     => 0,				// 日期

	's_info_set'   => 0,
	's_info_title' => '簡短介紹',
	'info_set'     => 1,                // 詳細介紹 -- 編輯器
	'info_title'   => '回答',
	'info2_set'    => 0,                // 備用介紹欄位 -- 編輯器
	'info2_title'  => '介紹2',
	'info3_set'    => 0,                // 備用介紹欄位 -- 編輯器
	'info3_title'  => '介紹3',
	'info4_set'    => 0,                // 備用介紹欄位 -- 編輯器
	'info4_title'  => '介紹4',
	'info5_set'    => 0,                // 備用介紹欄位 -- 編輯器
	'info5_title'  => '介紹5',

	//-------------驗證規則區-------------
	'rule' => [
		'no'          => 'filled|numeric',
		'upload_pic'  => "mimes:{$pic_mime}|max:{$pic_max_limit}",
		'upload_file' => "mimes:{$file_mime}|max:{$file_max_limit}",

		'act'    => "checkbox_num_limit:{$table},{$act_num},p_rack",
		'p_home' => "checkbox_num_limit:{$table},{$p_home_num},p_rack",
		'p_new'  => "checkbox_num_limit:{$table},{$p_new_num},p_rack",
		'p_run'  => "checkbox_num_limit:{$table},{$p_run_num},p_rack",
		'p_hot'  => "checkbox_num_limit:{$table},{$p_hot_num},p_rack",
	],

	'rule_message' => [
		'no.filled'         => '排序 不能為空值',
		'no.numeric'        => '排序 請輸入數字',
		'upload_pic.mimes'  => '圖片檔案格式有誤 限制：:values',
		'upload_pic.max'    => '圖片檔案大小不可超過 '.get_file_max($pic_max_limit),
		'upload_file.mimes' => '檔案格式有誤 限制：:values',
		'upload_file.max'   => '檔案大小不可超過 '.get_file_max($file_max_limit),

		'act.checkbox_num_limit'    => '上架 數量超過限制',
		'p_home.checkbox_num_limit' => $p_home_name.' 數量超過限制',
		'p_new.checkbox_num_limit'  => $p_new_name.' 數量超過限制',
		'p_run.checkbox_num_limit'  => $p_run_name.' 數量超過限制',
		'p_hot.checkbox_num_limit'  => $p_hot_name.' 數量超過限制',
	],
	//-------------------------------------
];