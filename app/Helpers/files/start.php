<?php

if (!function_exists('config')) {
    function config($key, $default = '')
    {
        $config_path = __DIR__ . '/../../../config/';

        // 分割 key 值
        $search = explode('.', $key);

        // 載入陣列
        if (in_array($search[0] . '.php', scandir($config_path))) {
            $data = require $config_path . $search[0] . '.php';
        } elseif (in_array($search[0] . '.php', scandir($config_path . 'system'))) {
            $data = require $config_path . 'system/' . $search[0] . '.php';
        } elseif (in_array($search[0] . '.php', scandir($config_path . 'api'))) {
            $data = require $config_path . 'api/' . $search[0] . '.php';
        } else {
            return '無資料 請檢察 key 是否輸入錯誤';
        }

        array_shift($search);

        // 取值
        foreach ($search as $index => $key) {
            $data = $data[$key];
        }

        (!is_bool($data) && empty($data)) AND $data = $default;

        return $data;
    }
}