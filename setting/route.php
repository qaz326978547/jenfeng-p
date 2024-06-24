<?php isset($check_system_key) or exit('No direct script access allowed'); // Framework - AhWei - fezexp9987@gmail.com - line: fezexp

// 全域中介層
foreach (config('middleware.global') as $key => $value) {
    middleware($value);
}

// 自定義服務啟動
require __DIR__ . '/../setting/boot.php';

// 路由 - 只接受三個參數 0 => Http Method , 2 => 控制器@方法 , 3 => 中介層

$path = urldecode(Request::path());
$path_array = array_diff(explode('/', $path), ['']);

// ---------------------------
	# 多語言暫時解法 配合 中介層
if (in_array($path_array[0] ?? '', config('system.global_route_lang'))) {
    if (count($path_array) > 1) {
        array_shift($path_array);
    } else {
        $path_array[0] = '/';
    }

    $path = implode('/', $path_array);
}
// ---------------------------

if (\Str::contains($path, 'admin')) {
	\Agent::isRobot() AND back('機器人!!');
}

$routes = route($path_array[0] ?? '');

$route = Collection::make($routes)
	    ->filter(function ($value, $key) use ($path, $path_array) {
	        if (array_key_exists($path, $value)) {
	            return $value;
	        } else {
	            if (in_array(($path_array[0] ?? '') . '.php', scandir(__DIR__ . '/../routes/'))) {
	                $base = $path_array[1] ?? '';
	            } else {
	                $base = $path_array[0] ?? '';
	            }

	            $str_before = \Str::before(array_keys($value)[0], '/{');

	            if (
	                \Str::contains($path, $str_before) &&
	                \Str::contains($str_before, $base) &&
	                $path != '/'
	            ) {
	                $len1 = count($path_array);
	                $len2 = count(explode('/', array_keys($value)[0]));

	                if ($len1 == $len2 && array_keys($value)[0] != '/') {
	                    $count1 = explode('/', $str_before);
	                    $count2 = array_intersect($path_array, explode('/', $str_before));

	                    if (count($count2) >= count($count1)) {
	                        return $value;
	                    }
	                }
	            }
	        }
	    })
	    ->filter(function ($value, $key) {
	        if (
	            strtolower(Request::method()) == reset($value)[0] ||
	            'any' == reset($value)[0] ||
	            'view' == reset($value)[0]
	        ) {
	            return $value;
	        }
	    })
	    ->toArray();

if (count($route) > 0) {
    // 判斷出正確路徑
    if (count($route) > 1) {
        $check_array = [];

        foreach ($route as $key => $value) {
            $str_before = \Str::before(array_keys($value)[0], '/{');
            $check_array[count(explode('/', $str_before))] = ['key' => $key, 'str' => $str_before];
        }

        krsort($check_array);

        foreach ($check_array as $key => $array) {
            if (\Str::contains($path, $array['str'])) {
                $route = $route[$array['key']];
                break;
            }
        }
    } else {
        $route = call_user_func_array('array_merge', array_values($route));
    }

    // 參數取得
    $parameters = [];

    if (isset($route[$path])) {
        $route = $route[$path];
    } else {
        foreach ($route as $key => $value) {
            $parameters = explode('/', str_replace(\Str::before($key, '/{'), '', $path));
            empty($parameters[0]) and array_shift($parameters);
        }

        $route = call_user_func_array('array_merge', array_values($route));
    }

    // 中介層
    if (!empty($route[2])) {
        foreach ($route[2] as $key => $value) {
            middleware(config('middleware.routeMiddleware')[$value]);
        }
    }

    if ($route[0] == 'view') {
        $view_str = $route[1];

        Response::create(View::make($view_str)->render())->send();

    } else {
        $controller_str = 'App\Controller\\' . \Str::before($route[1], '@');
        $method_str = \Str::after($route[1], '@');

        // 釋放陣列
        unset($routes);

        // 控制器
        with(new $controller_str())->{$method_str}(...$parameters);
    }
} else {
    // 靜態網頁判斷區 - 檔名需和路徑相同
    $view = str_replace('/', '.', $path);

    if (View::exists('web.' . $view)) {

        Response::create(View::make('web.' . $view)->render())->send();

    } elseif (View::exists('web.' . $view . '.index')) {

        Response::create(View::make('web.' . $view . '.index')->render())->send();

    } elseif (View::exists($view)) {

        Response::create(View::make($view)->render())->send();

    } elseif (View::exists($view . '.index')) {

        Response::create(View::make($view . '.index')->render())->send();

    } else {
        // 無符合 顯示 404 頁面
        Response::create(View::make('404')->render(), 404)->send();
    }
}

// 路由群組
function route($name)
{
    $route_path = __DIR__ . '/../routes/';

    if (in_array($name . '.php', scandir($route_path))) {
        return File::getRequire(__DIR__ . '/../routes/' . $name . '.php');
    } else {
        return File::getRequire(__DIR__ . '/../routes/web.php');
    }
}

// 中介層
function middleware($name)
{
    $middleware_str = 'App\Middleware\\' . $name;

    if (with(new $middleware_str)->handle() !== 'success') {
        exit("({$name}) 未通過");
    }
}