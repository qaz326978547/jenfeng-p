<?php

if (!function_exists('form_make')) {
    /**
     * 單選用
     *
     * @param  [int , array]  $data              [description]
     * @param  [array]        $array             [description]
     * @param  string         $input_name        [description]
     * @param  string         $input_type        [radio , checkbox]
     * @param  integer        $begin_key         [description]
     * @param  string         $class             [description]
     * @param  string         $seprate_dom_begin [description]
     * @param  string         $seprate_dom_end   [description]
     *
     * @return [string]
     */
    function form_make($data, $array, $input_name, $input_type = 'radio', $begin_key = 0, $class = '', $seprate_dom_begin = '', $seprate_dom_end = '')
    {
        $temp_string = ''; #暫存

        foreach ($array as $key => $array_name) {

            $temp_string .= $seprate_dom_begin;
            $temp_string .= '<input type="' . $input_type . '" class="' . $class . '"';

            //單選 radio
            if ($input_type == 'radio') {
                $temp_string .= ' name="' . $input_name . '" value="' . $begin_key . '" ';
                if ($data[$input_name] == $begin_key) {
                    $temp_string .= ' checked ';
                }}
            //複選 checkbox
            else {
                $temp_string .= ' name="' . $input_name . $begin_key . '" value="1" ';
                if ($data[$input_name . $begin_key] == 1) {
                    $temp_string .= ' checked ';
                }
            }

            $temp_string .= ' id="' . $input_name . $begin_key . '" />';
            $temp_string .= '<label class="no" for="' . $input_name . $begin_key . '">' . $array_name . '</label>';
            $temp_string .= $seprate_dom_end;

            $begin_key++; //累計

        }

        return $temp_string;
    }
}
