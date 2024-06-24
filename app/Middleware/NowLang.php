<?php

namespace App\Middleware;

/**
 * 備註
 *
 * 每個專案 正常這邊需要變動的就是 每個 switch case 裡面的內容，
 */
class NowLang
{
    public function handle()
    {
        // 讓api的背景接收不被影響
        $path_except = !empty(config('system.nowlang.path_except')) ? config('system.nowlang.path_except') : [];
        $api_check = \Str::contains(\Request::path(), $path_except) ? true : false;
        $api_check = ($api_check == false && empty(\Request::server('HTTP_COOKIE'))) ? true : false;

        // -------------------- 前台 --------------------
        $path_array = array_diff(explode('/', \Request::path()), ['']);

        if (in_array($path_array[0] ?? '', config('system.global_route_lang'))) {
            \Session::put('lang', $path_array[0]);
        } else {
            # 以瀏覽器語系判斷
            if (!\Session::has('lang') && !\Agent::isRobot() && !$api_check) {
                switch (\Agent::languages()[0]) {
                    // case 'en':
                    // case 'en-us':
                    // case 'en-gb':
                    // case 'en-ca':
                    // case 'en-au':
                    // case 'en-ie':
                    // case 'en-jm':
                    // case 'en-nz':
                    // case 'en-za':
                    // case 'en-tt':
                    // case 'en-bz':
                    //     array_unshift($path_array, 'en');
                    //     break;
                    default:
                        // array_unshift($path_array, 'tw');    // 呈現 /tw/..的意思
                        \Session::put('lang', 'tw');
                        break;
                }

                $path = implode('/', $path_array);
                $query = !empty(\Request::query()) ? '?' . http_build_query(\Request::query()) : '';

                return redirect($path . $query)->send();
            } else {
                # 原始網址預設 (意思就是 沒/en /tw 的時候)
                \Session::put('lang', 'tw');
            }
        }

        //     # GET切換
        // if(!empty(\Request::query('lang'))) {
        //     \Session::put('lang', \Request::query('lang'));
        // }

        # 常數設定
        switch (\Session::get('lang')) {
            case 'en':
                define('DB_LANG', '_en');
                define('KEY_SUFFIX_LANG', '_en');
                define('TITLE_CHAR', ' (英文)');
                break;
            default:
                define('DB_LANG', '');
                define('KEY_SUFFIX_LANG', '');
                define('TITLE_CHAR', ' (繁中)');
                break;
        }

        // -------------------- 後台 --------------------
        if (\Session::has('admuser')) {
            if (empty(\Session::get('admin_lang'))) {
                \Session::put('admin_lang', 'tw');
            }

            if (!empty(\Request::query('admin_lang'))) {
                \Session::put('admin_lang', \Request::query('admin_lang'));
            }

            switch (\Session::get('admin_lang')) {
                case 'en':
                    define('BACK_DB_LANG', '_en');
                    define('BACK_TITLE_CHAR', ' (英文)');
                    break;
                default:
                    define('BACK_DB_LANG', '');
                    define('BACK_TITLE_CHAR', ' ');
                    break;
            }
        }

        // 避免前端出現的警告
        if (!defined('BACK_TITLE_CHAR')) {
            define('BACK_TITLE_CHAR', '');
        }

		if (!defined('BACK_DB_LANG')) {
		    define('BACK_DB_LANG', '');
		}

        return 'success';
    }
}