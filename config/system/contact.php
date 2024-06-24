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

return [
	'config'   => 'contact',
	'table'    => 'contact' . $suffix,
	'folder'   => 'contact',
	'link_tag' => 'contact',

	'list_table' => 'contact_list',

	'page_title' => '立即報名' . BACK_TITLE_CHAR,
	'col_title'  => '',

	'page_show'	 => 10,				 // 資料每頁顯示比數

	//-------------驗證規則區-------------
	'rule' => [
		'class'          => 'required',
		'company'        => 'required',
		'tel'            => 'required|numeric',
		'num'            => 'required',
		
		// 'last5'          => 'required',
		// 'ticket'         => 'required',
		'ticket_name'    => 'required_if:ticket,3',
		'ticket_no'      => 'required_if:ticket,3',
		// 'ticket_address' => 'required',
		// 'from'           => 'required',
		// 'suggest_name'   => 'required',

		'name.*'         => 'required',
		'cel.*'          => 'required', 				
		'email.*'        => 'required',
	],
	'rule_message' => [
		'class.required'          => '報名課程 尚未選擇',
		'company.required'        => '公司名稱 尚未填寫',
		'tel.required'            => '公司電話 尚未填寫',
		'tel.numeric'             => '公司電話 請輸入數字',
		'num.required'            => '報名人數 尚未選擇', 
		'name.*.required'           => '參加人員:array_key 姓名 尚未填寫',		
		'cel.*.required'            => '參加人員:array_key 聯絡電話 尚未填寫',
		'cel.*.numeric'             => '參加人員:array_key 聯絡電話 請輸入數字',
		'email.*.required'          => '參加人員:array_key E-mail 尚未填寫',
		'email.*.email'             => '參加人員:array_key E-mail 不符合格式',
		
		'last5.required'          => '匯款後五碼 尚未填寫',
		'ticket.required'         => '發票 尚未選擇',
		'ticket_name.required_if' => '發票抬頭 尚未填寫',
		'ticket_no.required_if'   => '統一編號 尚未填寫',
		'ticket_address.required' => '發票寄送地址 尚未填寫',
		'from.required'           => '得知講座管道 尚未填寫',
		'suggest_name.required'   => '推薦人姓名 尚未填寫',
	],
	// 'rule_message_en' => [
	// 	'name.required'    => 'Please enter [Name].',
	// 	'sex.required'     => 'Please select [Gender].',
	// 	'tel.required'     => 'Please enter [Tel].',
	// 	'tel.numeric'      => '[Tel]  Please enter the number',
	// 	'email.required'   => 'Please enter [E-mail].',
	// 	'email.email'      => '[Email] is incorrect.',
	// 	'info.required'    => 'Please enter [Message].',
	// ],

	// 'captcha_rule' => [
	// 	'captcha' => 'required|in:'.\Session::get('captcha'),
	// ],

	// 'captcha_rule_message' => [
 //        'captcha.required' => '驗證碼 尚未填寫',
 //        'captcha.in'       => '驗證碼 輸入錯誤',
	// ],
	// 'captcha_rule_message_en' => [
	// 	'required' => 'Please enter [Captcha].',
	// 	'in'       => '[Captcha] Input error',
	// ],

	'g-recaptcha-response_rule' => [
		'g-recaptcha-response' => 'required|captcha',
	],

	'g-recaptcha-response_rule_message' => [
		'g-recaptcha-response.required' => '請確認你不是機器人!',
		'g-recaptcha-response.captcha'  => '驗證錯誤! 請稍後再試或者聯繫網站管理員',
	],
	// 'g-recaptcha-response_rule_message_en' => [
	// 	'g-recaptcha-response.required' => 'Please confirm that you are not a robot!',
	// 	'g-recaptcha-response.captcha'  => 'Verification error! Please try again later or contact the webmaster',
	// ],
	//-------------------------------------
];