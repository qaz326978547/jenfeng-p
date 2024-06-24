<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;

/**
 * Laravel 驗證
 * @example https://laravel-china.org/docs/laravel/5.6/validation
 */
class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 新增數量限制 參數:[0 => table, 1 => num]
        Validator::extend('add_limit', function ($attribute, $value, $parameters, $validator) {
            $table = $parameters[0];
            $num = $parameters[1] ?? 0;

            // 利用傳進來的 $value = 0 判斷為新增, 通常利用 id
            if ($value == 'add' && $num > 0) {
                $total = \DB::table($table)->where('del', 0)->count();

                if ($total >= $num) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });

        // checkbox 數量限制
        Validator::extend('checkbox_num_limit', function ($attribute, $value, $parameters, $validator) {
            $table = $parameters[0];
            $num = $parameters[1] ?? 0;
            $type = $parameters[2] ?? 'common';
            $rule_mode = $parameters[3] ?? 'all';

            $input = $validator->getData();
            $id = $input['id'];

            // Ajax 用
            $attribute == 'col' and $attribute = $value;

            // 原本為 checked, 不檢查
            if ($id != 0 && (\DB::table($table)->where('id', $id)->value($attribute) == 1)) {
                return true;
            }

            if ($num > 0) {
                // 產品架用
                if ($type == 'p_rack') {
                    // 找出 根 算出底下全部
                    if ($rule_mode == 'all') {
                        $total = \DB::table($table)
		                            ->where([[$attribute, 1], ['del', 0]])
		                            ->get()
		                            ->filter(function ($row, $key) use ($table) {
		                                $table = \Str::is('*_class', $table) ? $table : $table . '_class';
		                                $now_class_id = $row['class_id'];
		                                $class_ids = [$now_class_id];

		                                do {
		                                    $now_class_id = \DB::table($table)->where('id', $now_class_id)->value('class_id');
		                                    array_push($class_ids, $now_class_id);
		                                } while ($now_class_id != 0);

		                                if (\DB::table($table)->whereIn('id', $class_ids)->where('del', 1)->count() == 0) {
		                                    return $row;
		                                }
		                            })
		                            ->count();
                        // 只計算該類別
                    } elseif ($rule_mode == 'only') {
                        $class_id = \DB::table($table)->where('id', $id)->value('class_id');

                        $total = \DB::table($table)
		                            ->where([['class_id', $class_id], [$attribute, 1], ['del', 0]])
		                            ->get()
		                            ->count();
                    }
                } else {
                    // 一般用
                    $total = \DB::table($table)
                        ->where([[$attribute, 1], ['del', 0]])
                        ->get()
                        ->count();
                }

                if ($total + 1 > $num) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        });

        // 折扣折數檢查
        Validator::extend('discount', function ($attribute, $value, $parameters, $validator) {
            if ($value < 0.01 || $value > 0.99) {
                return false;
            } else {
                return true;
            }
        });

        // 身分證檢查
        Validator::extend('taiwan_id', function ($attribute, $value, $parameters, $validator) {

            $id = $value;

            $id = strtoupper($id);

            // 建立字母分數陣列

            $headPoint = array(
                'A' => 1, 'I' => 39, 'O' => 48, 'B' => 10, 'C' => 19, 'D' => 28,
                'E' => 37, 'F' => 46, 'G' => 55, 'H' => 64, 'J' => 73, 'K' => 82,
                'L' => 2, 'M' => 11, 'N' => 20, 'P' => 29, 'Q' => 38, 'R' => 47,
                'S' => 56, 'T' => 65, 'U' => 74, 'V' => 83, 'W' => 21, 'X' => 3,
                'Y' => 12, 'Z' => 30,
            );

            // 建立加權基數陣列
            $multiply = array(8, 7, 6, 5, 4, 3, 2, 1);

            // 檢查身份字格式是否正確

            if (preg_match("/^[a-zA-Z][1-2][0-9]+$/", $id) and strlen($id) == 10) {

                // 切開字串
                $stringArray = str_split($id);
                // 取得字母分數(取頭)
                $total = $headPoint[array_shift($stringArray)];
                // 取得比對碼(取尾)
                $point = array_pop($stringArray);
                // 取得數字部分分數
                $len = count($stringArray);
                for ($j = 0; $j < $len; $j++) {
                    $total += $stringArray[$j] * $multiply[$j];
                }
                // 計算餘數碼並比對
                $last = (($total % 10) == 0) ? 0 : (10 - ($total % 10));

                if ($last != $point) {
                    return false;
                } else {
                    return true;
                }

            } else {
                return false;
            }

            return false;
        });

        // 僅限中文
        Validator::extend('chinese_only', function ($attribute, $value, $parameters, $validator) {

            // 檢查是否中文 unicode檢查中文字元範圍
            if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $value)) {
                return true;
            } else {
                return false;
            }
        });

        // 陣列裡 至少 ? 個不能為空
        Validator::extend('required_array_at_least', function ($attribute, $value, $parameters, $validator) {
            $num = $parameters[0];
            $count = count(array_filter($value, function ($var) use ($parameters) {
                return !empty($var);
            })
            );

            return $count >= $num;
        });

// ---------------------------------------- 訊息 佔位符 替換自定義 ----------------------------------------

        // 自定義 required 錯誤訊息 佔位符
        Validator::replacer('required', function ($message, $attribute, $rule, $parameters, $validator) {
            $attribute = explode('.', $attribute);
            $array_key = ($attribute[1] ?? 0) + 1;

            return str_replace(':array_key', $array_key, $message);
        });

        // 自定義 required_array_at_least 錯誤訊息 佔位符
        Validator::replacer('required_array_at_least', function ($message, $attribute, $rule, $parameters, $validator) {
            return str_replace(':value', $parameters[0], $message);

        });

        // 自定義 mimes 錯誤訊息
        // Validator::replacer('mimes', function ($message, $attribute, $rule, $parameters, $validator) {
        // 	$message =  str_replace(':values', implode(', ', $parameters), $message);
        // 	$message = str_replace($attribute, \Arr::get($validator->getData(), $attribute)->getClientOriginalName(), $message);

        //     return $message;
        // });    

        // mimes 陣列用
        Validator::replacer('mimes', function ($message, $attribute, $rule, $parameters, $validator) {
            return str_replace([$attribute, ':values'], [data_get($validator->getData(), $attribute)->getClientOriginalName(), implode(', ', $parameters)], $message);

        }); 

        // max 陣列用
        Validator::replacer('max', function ($message, $attribute, $rule, $parameters, $validator) {
            return str_replace([$attribute], [data_get($validator->getData(), $attribute)->getClientOriginalName()], $message);

        });                 
    }

    public function register()
    {
        //
    }
}