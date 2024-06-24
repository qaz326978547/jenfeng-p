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

$table = 'page' . $suffix;

$pic_max_limit = 1024 * 2;		// 單圖大小限制 (單位:KB)
$pic_mime      = 'jpeg,png';	// 單圖MIME類型

$file_max_limit = 1024 * 20; 	// 單檔大小限制 (單位:KB)
$file_mime      = 'pdf';		// 單檔MIME類型

return [
	'config'   => 'page',
	'folder'   => 'page',
	'link_tag' => 'page',

	'table'       => $table,
	'pics_table'  => $table.'_pics', 	// 多圖資料表
	'files_table' => $table.'_files', 	// 多檔資料表

	'page_title' => 'Page' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'	 => 100,				 // 資料每頁顯示比數

	//---------  圖片 ---------
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
	'file_max_limit' => $file_max_limit,
	'file_mime'      => $file_mime,			// 單檔MIME類型

	'multfile_set'       => 0,           	// 多檔上傳
	'multfile_max_limit' => 1024 * 20,		// 多檔大小限制 (單位:KB)
	'multfile_mime'      => 'pdf',			// 多檔MIME類型

    // 開放區
	'act_id_set'      => [],
	'name_id_set'     => [],
	'e_name_id_set'   => [],
	'sub_name_id_set' => [],
	'pic_id_set'      => [],
	'pics_id_set'     => [],	// 多圖
	'file_id_set'     => [],
	'files_id_set'    => [],	// 多檔
	'link_id_set'     => [],
	'utube_id_set'    => [],
	's_info_id_set'   => [ 2 ],
	'info_id_set'     => [ 1 , 2],

	//-------------驗證規則區-------------
	'rule' => [
		// 'path'     => "unique:{$table},path",
		'upload_pic'  => "mimes:{$pic_mime}|max:{$pic_max_limit}",
		'upload_file' => "mimes:{$file_mime}|max:{$file_max_limit}",
	],

	'rule_message' => [
		// 'path.unique'      => '路徑重複',
		'upload_pic.mimes'  => '圖片檔案格式有誤 限制：:values',
		'upload_pic.max'    => '圖片檔案大小不可超過 '.get_file_max($pic_max_limit),
		'upload_file.mimes' => '檔案格式有誤 限制：:values',
		'upload_file.max'   => '檔案大小不可超過 '.get_file_max($file_max_limit),
	],
	//-------------------------------------
];