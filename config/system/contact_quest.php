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

$table = 'contact_quest' . $suffix;

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$num_limit = 12;		  	// 新增數量限制  0 不限制

return [
	'config'   => 'contact_quest',
	'table'    => $table,
	'folder'   => 'contact_quest',
	'link_tag' => 'contact_quest',

	'page_title' => '問題' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'	 => 10,				 // 資料每頁顯示比數
 

	//-------------驗證規則區-------------
	'rule' => [
		'name'      => 'required',		
		'action'     => "add_limit:{$table},{$num_limit}",
	],

	'rule_message' => [
		'name.required'   => '標題 不能為空值',		
		'action.add_limit' => '數量超出限制數量，新增失敗',
	],
	//-------------------------------------
];