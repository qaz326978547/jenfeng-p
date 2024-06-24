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

$table = 'seo' . $suffix;

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

return [
	'config'      => 'seo',
	'folder'      => 'seo',
	'link_tag'    => 'seo',

	'table'        => $table,
	'class_table'  => $table.'_class',	// 類別資料表
	'pics_table'   => $table.'_pics', 	// 多圖資料表

	'page_title' => 'SEO' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'  => 10,				 	// 資料每頁顯示比數

	//---------  圖片 ---------
	'pic_set'       => 1,                // 單一圖片上傳
	'pic_edit'      => 0,
	'pic_width'     => 1920,
	'pic_height'    => 1920,
	'pic_max_limit' => $pic_max_limit,   // 圖片大小限制
	'pic_mime'      => $pic_mime,	     // 圖片MIME類型

	'multpic_set'       => 0,            // 額外圖片(大量上傳)
	'multpic_edit'      => 0,
	'multpic_width'     => 1920,		 // 多圖寬度
	'multpic_height'    => 1920,		 // 多圖高度
	'multpic_max_limit' => 1024 * 2,	 // 多圖大小限制 (單位:KB)
	'multpic_mime'      => 'jpeg,png',	 // 多圖MIME類型

	//-------------驗證規則區-------------
	'rule' => [
		'upload_pic' => "mimes:{$pic_mime}|max:{$pic_max_limit}",
	],

	'rule_message' => [
		'upload_pic.mimes' => '圖片檔案格式有誤 限制：:values',
		'upload_pic.max'   => '圖片檔案大小不可超過 '.get_file_max($pic_max_limit),
	],
	//-------------------------------------
];