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

$table = 'browse' . ($suffix ?? '');

return [
	'config'   => 'browse',
	'folder'   => 'browse',
	'link_tag' => 'browse',

	'table'        => $table,
	'record_table' => $table.'_record', // 記錄資料表

	'page_title' => '瀏覽' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'	 => 10,				 // 資料每頁顯示比數

	//-------------驗證規則區-------------
	'rule' => [
		'start_num'  => 'required|numeric',
	],

	'rule_message' => [
		'start_num.required' => '起始數 不能為空值',
		'start_num.numeric'  => '起始數 請輸入數字',
	],
	//-------------------------------------
];