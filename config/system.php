<?php // Framework v75_4 - 2023/02/21 AhWei - fezexp9987@gmail.com - line: fezexp

// $base_path = '/業務/dev_default/';
$base_path = '/ethan_jinfeng/';
$base_path = '/';
$web_title = '金豐';

return [
	# 請隨意更改 每個專案都不同最好
// =========================================================================
	'key' => '$2y$10$RpKsdifSumaabOjd2geF5R1QKEIIyWkWjYqyIoPNMaHa',
// =========================================================================

	// --------------------- 環境控制 -- local public -- 上線 記得改成 public ---------------------
	'env'               => 'public',
	'global_route_lang' => ['tw', 'en'], // 多語言路由path共用設定 記得NowLang中介層switch也要同步喔
	'use_httpTohttps'   => 1,			// 強制轉成https
	'redirect_301' => [			// 301重定向 解決副域名被google搜尋到的問題
		'use' => 0,	#本機修改的時候記得改成0
		'url' => [''],	# ex: test.com
	],

	'base_path'         => $base_path,
	'web_title'         => $web_title,

	// CSRF 中介層跳脫
	'csrf' => [
		'path_except'  => [],
		'input_except' => ['MerchantID', 'InvoiceNumber'],
	],

	// 多語言 中介層跳脫
	'nowlang' => [
		'path_except' => ['cron', 'ecpay', 'newebpay'],
	],

	// 套件 Config 設定載入 - 安裝laravel相關套件 需要注意此設定 有問題找ahwei [key => 套件config key , value => config 檔名]
	'config_load' => [
		'app'          => 'mystery',
		'database'     => 'database',
		'session'      => 'session',
		'filesystems'  => 'filesystems',
		'logging'      => 'logging',
		'cache'        => 'cache',
		'view'         => 'view',
		'mail'         => 'mail',
		'services'     => 'socialite',
		'excel'        => 'excel',
		'image'        => 'image',
		'captcha'      => 'recaptcha',
		'debug-server' => 'debug-server',
	],

	// --------------------- Provider ---------------------
	'providers_register' => [
		Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Events\EventServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        // Illuminate\Mail\MailServiceProvider::class,
        App\Providers\MailServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\Log\LogServiceProvider::class,

        App\Providers\HelperServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        App\Providers\ExcelServiceProvider::class,
        App\Providers\ImageServiceProvider::class,
        Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
        BeyondCode\DumpServer\DumpServerServiceProvider::class,
        App\Providers\GeneratorServiceProvider::class,
	],

	'providers_boot' => [
		App\Providers\EventServiceProvider::class,
		App\Providers\ViewServiceProvider::class,
		App\Providers\BladeServiceProvider::class,
		App\Providers\ValidatorServiceProvider::class,
		App\Providers\ExceptionServiceProvider::class,
		Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
	],

	// --------------------- aliases ---------------------
    'aliases' => [
		// 'DB'          => Illuminate\Support\Facades\DB::class,
		'DB'             => AhWei\DB\Repository::class,
		'Eloquent'       => Illuminate\Database\Eloquent\Model::class,
		'Event'          => Illuminate\Support\Facades\Event::class,
		'File'           => Illuminate\Support\Facades\File::class,
		'Storage'        => Illuminate\Support\Facades\Storage::class,
		'Session'        => Illuminate\Support\Facades\Session::class,
		'Cookie'         => Illuminate\Support\Facades\Cookie::class,
		'Cache'          => Illuminate\Support\Facades\Cache::class,
		'View'           => Illuminate\Support\Facades\View::class,
		'Blade'          => Illuminate\Support\Facades\Blade::class,
		'Mail'           => Illuminate\Support\Facades\Mail::class,
		'Crypt'          => Illuminate\Support\Facades\Crypt::class,
		'Hash'           => Illuminate\Support\Facades\Hash::class,
		'Log'            => Illuminate\Support\Facades\Log::class,
		'Collection'     => Illuminate\Support\Collection::class,
		'LazyCollection' => Illuminate\Support\LazyCollection::class,
		'Validator'      => Illuminate\Support\Facades\Validator::class,
		'Rule'           => Illuminate\Validation\Rule::class,
		'Request'        => Illuminate\Support\Facades\Request::class,
		'Redirect'       => Illuminate\Http\RedirectResponse::class,
		'Response'       => Illuminate\Http\Response::class,
		'JsonResponse'   => Illuminate\Http\JsonResponse::class,
		'Arr'            => Illuminate\Support\Arr::class,
		'Str'            => Illuminate\Support\Str::class,
		'Http'           => Illuminate\Support\Facades\Http::class,

		'Socialite' => Laravel\Socialite\Facades\Socialite::class,
		'Date'      => Carbon\Carbon::class,
		'Agent'     => Jenssegers\Agent\Facades\Agent::class,
		'Excel'     => Maatwebsite\Excel\Facades\Excel::class,
		'Image'     => Intervention\Image\Facades\Image::class,
		'NoCaptcha' => Anhskohbo\NoCaptcha\Facades\NoCaptcha::class,
    ],
];