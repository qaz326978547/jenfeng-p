<?php

use App\ClassMap\ResponseFactory;

if (!function_exists('app')) {
    /**
     * Get the available container instance. - 非正常操作 不要學
     */
    function app($abstract = null)
    {
        global $app;

        if (is_null($abstract)) {
            return $app;
        }

        return $app[$abstract];
    }
}

if (! function_exists('response')) {
    /**
     * Return a new response from the application. - 非正常操作 不要學
     *
     * @return \Illuminate\Http\Response
     */
    function response()
    {
        return new ResponseFactory;
    }
}