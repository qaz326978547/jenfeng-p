<?php

if (!function_exists('MaskString')) {
    /**
     * function MaskString(): Mask a string for security.
     * @scope public
     * @param string $s : input string, >2 characters long string
     * @param interger $masknum : the number of characters in the middle of a string to be masked, if masknum is negative,
    the returned string will leave abs(masknum) characters in both end untouched.
     * @return a masked string
     * ex. MaskString( "12345678",3)  : 123***78
     * ex. MaskString( "12345678",-3)  : 12*****8
     */
    function MaskString($s)
    {

        $len = mb_strlen($s, 'utf-8');

        if ($len <= 1) {
            return $s;
        } elseif ($len <= 2) {
            return mb_substr($s, 0, 1, 'utf-8') . str_repeat('*', $len - 1);
        } elseif ($len <= 3) {
            return mb_substr($s, 0, 1, 'utf-8') . str_repeat('*', $len - 2) . mb_substr($s, $len - 1, 1, 'utf-8');
        }

        return mb_substr($s, 0, 1, 'utf-8') . str_repeat('*', $len - 3) . mb_substr($s, $len - 2, 2, 'utf-8');

    }
}