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

// $table = 'html_editor_manager_admin' .  $suffix; // 多語言 圖片管理器資料也要不同 才開啟
$table = 'html_editor_manager_admin';

return [
	'config'   => 'html_editor_manager_admin',

	'folder'   => 'admin.html-editor',
	'link_tag' => 'admin/html-editor',

	'table'      => $table,
	'pics_table' => $table.'_pics', 	// 多圖資料表

	'multpic_edit'      => 0,
	'multpic_width'     => 1920,		 // 多圖寬度
	'multpic_height'    => 1920,		 // 多圖高度
	'multpic_max_limit' => 1024 * 2,	 // 多圖大小限制 (單位:KB)
	'multpic_num_limit' => 0,	 		 // 多圖數量限制
	'multpic_mime'      => 'jpeg,png',	 // 多圖MIME類型

	//-------------驗證規則區-------------
	'rule' => [
		'no' => 'required|numeric',
	],

	'rule_message' => [
		'no.required' => '排序 不能為空值',
		'no.numeric'  => '排序 請輸入數字',
	],
	//-------------------------------------
];