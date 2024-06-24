<?php

/**
 * 驗證規則寫在相對應的 Config 或集中在這裡
 */

return [
	// 後台登入
	'admin_login' => [
		'rule' => [
            'account'  => 'required|exists:admin,account',
            'password' => 'required',
		],

		'rule_message' => [
            'account.required'  => '帳號不可為空白',
            'password.required' => '密碼不可為空白',
            'account.exists'    => '帳號不存在',
		],
	],
	// 後台修改密碼
	'admin_upd_pw' => [
		'rule' => [
			'password' => 'required',
			'confirm'  => 'required|same:password',
		],

		'rule_message' => [
			'password.required' => '新密碼不可為空白',
			'confirm.required'  => '確認新密碼尚未填寫',
			'confirm.same'      => '兩次輸入的新密碼不同',
		],
	],

];