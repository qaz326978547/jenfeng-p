<?php

if (!function_exists('lang')) {
    /**
     * 翻譯搜尋
     *
     * @param  [string] $search [利用 點 來搜尋 ex: 'language.tw']
     * @return [array|string]
     */
    function lang($search)
    {
        $lang_path = __DIR__ . '/../../resources/lang/';

        // 分割 key 值
        $search = explode('.', $search);
        // 載入翻譯檔陣列
        if (in_array(Session::get('lang', 'tw') . '.php', scandir($lang_path))) {
            $data = require __DIR__ . '/../../resources/lang/' . Session::get('lang', 'tw') . '.php';
        } else {
            $data = require __DIR__ . '/../../resources/lang/tw.php';
        }

        // 取值
        foreach ($search as $index => $key) {
            $data = $data[$key];
        }

        empty($data) and $data = '空值';

        return $data;
    }
}