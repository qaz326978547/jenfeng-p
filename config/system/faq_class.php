<?php

// 多語言判斷
// if (Request::ajax() === false) {
// 	if (\Str::contains(Request::path(), 'admin')) {
// 		$suffix = BACK_DB_LANG;
// 	} else {
// 		$suffix = DB_LANG;
// 	}
// } else {
// 	if (\Str::contains(Session::get('previous_url'), 'admin')) {
// 		$suffix = BACK_DB_LANG;
// 	} else {
// 		$suffix = DB_LANG;
// 	}
// }

$table = config('faq.table').'_class';

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$p_home_num = 1;			// 首頁 顯示筆數，依照勾選順序,不限制時輸入0
$act_num = 0;

return [
	'config'   => config('faq.config').'_class',
	'table'    => $table,
	'folder'   => config('faq.folder').'_class',
	'link_tag' => config('faq.link_tag').'_class',

	'page_title' => 'FAQ' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'sys_level'  => 1,			 		// 產品架最大層數，當類別屆於此值時，便不可再新增類別層數

	'page_show'  => 10,				    // 資料每頁顯示比數

	//---------  上傳圖片 ---------
	'pic_set'       => 0,                 // 單一圖片上傳
	'pic_edit'      => 0,
	'pic_width'     => 1920,
	'pic_height'    => 1920,
	'pic_max_limit' => $pic_max_limit, // 圖片大小限制
	'pic_mime'      => $pic_mime,	   // 圖片MIME類型

	//--------- 首頁上架 ---------
	'p_home_set'      => 0,                		// 首頁限定筆數顯示
	'p_home_num'      => $p_home_num,           // 首頁顯示筆數，依照勾選順序,不限制時輸入0
	'p_home_name'     => '首頁上架',       		// 首頁限定顯示 --名稱

	'act_num' => $act_num,

	//-------------驗證規則區-------------
	'rule' => [
		'no'         => 'required|numeric',
		'upload_pic' => "mimes:{$pic_mime}|max:{$pic_max_limit}",

		'act'    => "checkbox_num_limit:{$table},{$act_num},p_rack",
		'p_home' => "checkbox_num_limit:{$table},{$p_home_num},p_rack",
	],

	'rule_message' => [
		'no.required'      => '排序 不能為空值',
		'no.numeric'       => '排序 請輸入數字',
		'upload_pic.mimes' => '圖片檔案格式有誤 限制：:values',
		'upload_pic.max'   => '圖片檔案大小不可超過 '.get_file_max($pic_max_limit),

		'act.checkbox_num_limit'    => '上架 數量超過限制',
		'p_home.checkbox_num_limit' => '首頁上架 數量超過限制',
	],
	//-------------------------------------
];