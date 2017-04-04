<?php

namespace Midnite81\Helpers;

if (!function_exists('concatenate')) {
    /**
     * Concatenate strings together
     *
     * @return string
     */
    function concatenate()
    {
        $args = func_get_args();
        if (!empty($args)) {
            foreach ($args as $key => $arg) {
                if (is_object($args) || is_array($arg)) {
                    unset($args[$key]);
                }
            }
        }
        return implode('', $args);
    }
}

if (! function_exists('concatenate_with_separator')) {
    /**
     * Concatenate strings with specified separator as first argument
     *
     * @return string
     */
    function concatenate_with_separator()
    {
        $args = func_get_args();
        $separator = (isset($args[0])) ? $args[0] : ' ';
        unset($args[0]);
        if (!empty($args)) {
            foreach ($args as $key => $arg) {
                if (is_object($args) || is_array($arg)) {
                    unset($args[$key]);
                }
            }
        }
        return implode($separator, $args);
    }
}

if (! function_exists('getDbProperty')) {
    function getDbProperty($term, $table, $column = 'name') {

        return \Illuminate\Support\Facades\DB::table($table)
            ->where($column, $term)
            ->first();
    }
}