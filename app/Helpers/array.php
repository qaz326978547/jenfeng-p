<?php

if (!function_exists('combine_array_by_key')) {
    # 根據兩個數組的key，合併兩個數組來創建一個新數組，其中的一個數組元素為鍵名，另一個數組元素為鍵值
    function combine_array_by_key(array $key_array, array $value_array)
    {
        $array = [];

        foreach ($key_array as $index => $key_name) {
            $array[$key_name] = $value_array[$index];
        }

        return $array;
    }
}
