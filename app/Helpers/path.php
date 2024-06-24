<?php

if (!function_exists('url')) {
    /**
     * 方便製作 GET url
     */
    function url($path, $parameters = [])
    {
        $base_path = config('system.base_path');
        $get_str = '';
        $array = [];

        foreach ($parameters as $key => $value) {
            array_push($array, trim($value));
        }

        $get_str = implode('/', $array);

        if ($get_str != '') {
            return trim($base_path . $path . '/' . $get_str);
        } else {
            return trim($base_path . $path);
        }
    }
}

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return config('system.base_path') . $path;
    }
}

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return config('system.base_path') . 'config/' . $path;
    }
}

if (!function_exists('resources_path')) {
    function resources_path($path = '')
    {
        return config('system.base_path') . 'resources/' . $path;
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return $path ? config('system.base_path') . 'storage/' . $path : '';
    }
}

if (!function_exists('host_path')) {
    function host_path($path = '')
    {
        $prefix = \Request::secure() ? 'https://' : 'http://';

        return $prefix . \Request::server('HTTP_HOST') . $path;
    }
}