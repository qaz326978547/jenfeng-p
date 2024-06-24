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

$table = 'banner' . $suffix;

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$act_num = 0;

$num_limit = 5;		  	// 新增數量限制  0 不限制

return [
	'config'   => 'banner',
	'table'    => $table,
	'folder'   => 'banner',
	'link_tag' => 'banner',

	'page_title' => '首頁圖片' . BACK_TITLE_CHAR,
	'col_title'  => '圖片',

	'page_show'	 => 10,				 // 資料每頁顯示比數

	'pic_edit'      => 0,
	'pic_width'     => 1920,
	'pic_height'    => 1280,
	'pic_max_limit' => $pic_max_limit, // 圖片大小限制
	'pic_mime'      => $pic_mime,	   // 圖片MIME類型

	'act_num' => $act_num,

	'num_limit' => $num_limit,

	//-------------驗證規則區-------------
	'rule' => [
		'no'         => 'required|numeric',
		'upload_pic' => "mimes:{$pic_mime}|max:{$pic_max_limit}",
		'action'     => "add_limit:{$table},{$num_limit}",
		'act'        => "checkbox_num_limit:{$table},{$act_num}",
	],

	'rule_message' => [
		'no.required'      => '排序 不能為空值',
		'no.numeric'       => '排序 請輸入數字',
		'upload_pic.mimes' => '圖片檔案格式有誤 限制：:values',
		'upload_pic.max'   => '圖片檔案大小不可超過 '.get_file_max($pic_max_limit),
		'action.add_limit' => '已上傳圖片數量超出限制數量，新增失敗',
		'act.checkbox_num_limit'    => '上架 數量超過限制',
	],
	//-------------------------------------
];