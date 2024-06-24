<?php

// 檔案大小 - 後台用
if (!function_exists('get_file_max')) {
    function get_file_max($file_size)
    {
        if ($file_size >= 1024) {
            return $file_size = mb_substr(($file_size / 1024), 0, 6, "UTF-8") . 'MB';
        } else {
            return $file_size . 'KB';
        }
    }
}

// 檔案大小 - 前台用
if (!function_exists('get_file_size')) {
    function get_file_size($file_size)
    {
        if ($file_size > 1024 * 1024) {
            $file_size = round($file_size / (1024 * 1024), 1) . " MB";
        } else {
            $file_size = floor($file_size / 1024) . " KB";
        }

        return $file_size;
    }
}