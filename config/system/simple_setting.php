<?php

// 多語言判斷
if(Request::ajax() === false) {
	if(\Str::contains(Request::path(), 'admin')) {
		$suffix = BACK_DB_LANG;
	} else {
		$suffix = DB_LANG;
	}
} else {
	if(\Str::contains(Session::get('previous_url'), 'admin')) {
		$suffix = BACK_DB_LANG;
	} else {
		$suffix = DB_LANG;
	}
}

$table = 'simple_setting' . $suffix;

return [
	'config'   => 'simple_setting',
	'table'    => $table,
	'folder'   => 'simple_setting',
	'link_tag' => 'simple_setting',

	'page_title' => '簡易設定' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'	 => 100,				 // 資料每頁顯示比數

	//-------------驗證規則區-------------
	'rule' => [
		'' => "",
	],

	'rule_message' => [
		'' => '',
	],
	//-------------------------------------
];