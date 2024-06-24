<?php

if (!function_exists('validate')) {
    # 驗證器
    function validate(array $rules, array $messages = [], $validate_path = '')
    {
        \Request::merge(array_map(function ($value) {
            if (is_string($value)) {
                return trim($value);
            } else {
                return $value;
            }
        }, Request::all()));

        $validator = \Validator::make(\Request::all(), $rules, $messages);

        if ($validator->fails()) {
            \Session::flash("validate.path.{$validate_path}", 'fail');

            if (!\Request::ajax()) {
                back()->withErrors($validator->errors())->send();
                exit;
            } else {
                \JsonResponse::create($validator->errors()->all(), 422)->send();
                exit;
            }
        } else {
            if (!empty($validate_path)) {
                \Session::flash("validate.path.{$validate_path}", 'pass');
            }
        }

    }
}