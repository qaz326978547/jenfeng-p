<?php

/**
 * SEO 注意  兩層以上還沒規劃好~~~~~~~~~~~~~
 */

$table = config('seo.table').'_class';

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$p_home_num   = 1;			// 首頁 顯示筆數，依照勾選順序,不限制時輸入0

return [
	'config'   => config('seo.config').'_class',
	'folder'   => config('seo.folder').'_class',
	'link_tag' => config('seo.link_tag').'_class',

	'table'      => $table,
	'pics_table' => $table.'_pics', 	// 多圖資料表

	'page_title' => 'SEO' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'sys_level'  => 1,			 		// 產品架最大層數，當類別屆於此值時，便不可再新增類別層數

	'page_show'  => 10,				    // 資料每頁顯示比數

	//---------  上傳圖片 ---------
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
	'multpic_num_limit' => 0,	 		 // 多圖數量限制
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