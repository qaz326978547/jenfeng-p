<?php

use Carbon\Carbon;

if (!function_exists('dateformat')) {
    // 日期格式轉換
    function dateformat($date, $format)
    {

        $date = Carbon::parse($date)->format($format);

        return $date;
    }
}

if (!function_exists('get_chinese_weekday')) {
    // 日期轉中文星期函數
    function get_chinese_weekday($date)
    {

        $weekday  = Carbon::parse($date)->format('w');
        $weeklist = array('日', '一', '二', '三', '四', '五', '六');

        return $weeklist[$weekday];
    }
}