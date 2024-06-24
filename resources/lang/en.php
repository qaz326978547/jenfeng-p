<?php
// ************************原則************************
//        1. 目前依照前端頁面所看到的 "由上往下" 呈現
// **************************************************

return [

	'web_title' => '',
	'address'   => '',

	'language' => [
		'tw' => '繁體中文',
		'en' => 'English',
	],

	'google-map' => [
		'lang' => 'en',
	],

	'NoCaptcha' => [
		'lang' => 'en',
	],

	'layout' => [
		'html-lang' => 'en',
	],

	'header' => [

	],

	// 首頁
	'home' => [
		'title' => 'Home',
	],

	// 關於我們
	'about' => [
		'title' => 'About',
	],

	// 最新消息
	'news' => [
		'title' => 'News',

	    'back' => 'Back',
	],

	// 產品介紹
	'product' => [
		'title' => 'Product',

		'back'  => 'Back',
	],

	// 會員
	'member' => [
		'title' => 'Member',

		'login' => [
			'title' => 'Member Login',

			'check' => [
				'need'     => 'Please login',
				're'       => 'Please login again',
				'no-data'  => 'Member does not exist',
				'block'    => 'Login failed, This account has been disabled',
				'empty'    => 'Login failed, account does not exist',
				'error-pw' => 'Login failed, password is wrong',
				'success'  => 'Successful login',
			],

			'view' => [
				'account'     => 'Account',
				'password'    => 'Password',
				'forget_pw'   => 'Forgot your password',

				'login'    => 'Login',
				'register' => 'Register',
			],
		],

		'register' => [
			'title' => 'Member Register',

			'check' => [
				'account-used'    => 'This account is already used',
				'add-success'     => 'Member added successfully',
				'add-success-api' => 'Member added successfully, the default password is the same as your email, please change your password.',
				'add-fail'        => 'Member failed to join',
				'login'           => 'Successful login',
			],

			'view' => [
			    'form' => [
					'account'  => [
						'title'       => 'Account',
						'placeholder' => '',
					],
					'password' => [
						'title'       => 'Password',
						'placeholder' => 'Must be an alphanumeric combination of 6 characters or more',
					],
					'confirm_pw' => [
						'title'       => 'Confirm Password',
						'placeholder' => 'Please Enter the Password Again',
					],
					'name' => [
						'title'       => 'Name',
						'placeholder' => '',
					],
					'address' => [
						'title'       => 'Address',
						'placeholder' => '',
					],

					'send' => 'Send',
			    ],
			],
		],

		'logout' => [
			'title' => 'LOGOUT',

			'success' => 'Logged out',
		],

		'forget' => [
			'title' => 'Forgot Password',

			'check' => [
				'empty'        => 'There is no matching data for your query',
				'change-fail'  => 'Password change failed',
				'mail-success' => 'Password letter has been sent to this E-mail',
				'mail-fail'    => 'Password letter failed to send',
			],

			'view' => [
				'form' => [
					'email' => [
						'title'       => 'E-mail',
						'placeholder' => '',
					],

					'send' => 'Send',
				],
			],

			'mail-subject' => 'Member forgot password letter',
		],

		'upd' => [
			'title' => 'MEMBER DATA',

			'check' => [
				'upd' => [
					'success' => 'Change succeeded',
					'fail'    => 'Change failed',
				],

				'upd_pw' => [
					'success' => 'Password changed successfully',
					'fail'    => 'Password change failed',
					'old_pw'  => 'Old password input error',
				],
			],

		    'view' => [
		    	'upd_form' => [
		    		'title' => 'Data Change',

		    		'send' => 'Send',
		    	],

		    	'pw_form' => [
		    		'title' => 'Password Change',

					'old_password' => 'Old Password',
					'password'     => 'New Password',
					'confirm_pw'   => 'Confirm Password ',

					'send' => 'Send',
		    	],
		    ],
		],
	],

	// 聯絡我們
	'contact' => [
		'title' => 'Contact Us',

	    'form' => [
			'name'  => 'Name',
			'tel'   => 'Tel',
			'email' => 'Email',
			'info'  => 'Message',

			'send' => 'Send',
	    ],

		'data_error'     => 'Incorrect information, Please re-fill',
		'send_mail_fail' => 'Mail delivery failed',
		'process_msg'    => 'Thank you for your message',
	],

	// footer
	'footer' => [

	],

	'common' => [
		'go-home' => 'Home',
	],	
];