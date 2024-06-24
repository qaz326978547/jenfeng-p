<?php
// ************************原則************************
//        1. 目前依照前端頁面所看到的 "由上往下" 呈現
// ****************************************************

return [

	'web_title' => '',
	'address'   => '',

	'language' => [
		'tw' => '繁體中文',
		'en' => 'English',
	],

	'google-map' => [
		'lang' => 'zh-TW',
	],

	'NoCaptcha' => [
		'lang' => 'zh-TW',
	],

	'layout' => [
		'html-lang' => 'zh-Hant',
	],

	'header' => [

	],

	// 首頁
	'home' => [
		'title' => '首頁',
	],

	// 關於我們
	'about' => [
		'title' => '關於我們',
	],

	// 最新消息
	'news' => [
		'title' => '最新消息',

		'back'  => '回前頁',
	],

	// 產品介紹
	'product' => [
		'title' => '產品介紹',

		'back'  => '回前頁',
	],

	// 會員
	'member' => [
		'title' => '會員',

		'login' => [
			'title' => '會員登入',

			'check' => [
				'need'     => '請先登入會員',
				're'       => '請重新登入會員',
				'no-data'  => '會員不存在',
				'block'    => '登入失敗, 此帳號已停用',
				'empty'    => '登入失敗, 查無此帳號',
				'error-pw' => '登入失敗, 密碼錯誤',
				'success'  => '成功登入',
			],

			'view' => [
				'account'     => '帳號',
				'password'    => '密碼',
				'forget_pw'   => '忘記密碼',

				'login'    => '登入',
				'register' => '註冊',
			],
		],

		'register' => [
			'title' => '會員註冊',

			'check' => [
				'account-used'    => '此帳號已被使用',
				'add-success'     => '會員加入成功',
				'add-success-api' => '加入會員成功, 預設密碼與您的信箱相同,請更改您的密碼.',
				'add-fail'        => '會員加入失敗',
				'login'           => '成功登入',
			],

			'view' => [
			    'form' => [
					'account'  => [
						'title'       => '帳號',
						'placeholder' => '',
					],
					'password' => [
						'title'       => '密碼',
						'placeholder' => '需為6字元以上的英數組合',
					],
					'confirm_pw' => [
						'title' => '確認密碼',
					],
					'name' => [
						'title'       => '姓名',
						'placeholder' => '',
					],
					'address' => [
						'title'       => '通訊地址',
						'placeholder' => '',
					],
					
					'send' => '送出',
			    ],
			],
		],

		'logout' => [
			'title' => '會員登出',

			'success' => '感謝您的使用，已為您登出.',
		],

		'forget' => [
			'title' => '忘記密碼',

			'check' => [
				'empty'        => '無符合的資料',
				'change-fail'  => '密碼變更失敗',
				'mail-success' => '密碼信件已寄送至此E-mail信箱',
				'mail-fail'    => '密碼信件寄送失敗',
			],

			'view' => [
				'form' => [
					'email' => [
						'title'       => 'E-mail',
						'placeholder' => '',
					],

					'send' => '送出',
				],
			],

			'mail-subject' => '會員忘記密碼信',
		],

		'upd' => [
			'title' => '會員資料',

			'check' => [
				'upd' => [
					'success' => '修改成功',
					'fail'    => '修改失敗',
				],

				'upd_pw' => [
					'success' => '密碼修改成功',
					'fail'    => '密碼修改失敗',
					'old_pw'  => '舊密碼輸入錯誤',
				],
			],

		    'view' => [
		    	'upd_form' => [
		    		'title' => '基本資料修改',

		    		'send' => '修改確認',
		    	],

		    	'pw_form' => [
		    		'title' => '密碼修改',

					'old_password' => '舊密碼輸入',
					'password'     => '新密碼輸入',
					'confirm_pw'   => '再次輸入新密碼 ',

					'send' => '修改確認',
		    	],
		    ],
		],
	],

	// 聯絡我們
	'contact' => [
		'title' => '聯絡我們',

	    'form' => [
			'name'  => '姓名',
			'tel'   => '電話',
			'email' => 'E-mail',
			'info'  => '留言內容',

			'send' => '送出',
	    ],

		'data_error'     => '資料有誤，請重新填寫',
		'send_mail_fail' => '信件寄送失敗',
		'process_msg'    => '感謝您的留言',
	],

	// footer
	'footer' => [

	],

	'common' => [
		'go-home' => '回首頁',
	],	
];