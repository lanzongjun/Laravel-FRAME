<?php

if (!function_exists('is_valid_phone')) {
    function is_valid_phone($number)
    {
        if (!is_string($number)) {
            return false;
        }
        $number = strtr($number, array('-' => '', ' ' => '', '(' => '', ')' => ''));
        $pattern = '/^(?:\+?0?86)?(?:17951)?(1\d{10})$/';
        if (preg_match($pattern, $number, $matches)) {dd($matches);
            return $matches[1];
        }

        return false;
    }
}