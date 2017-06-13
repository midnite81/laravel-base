<?php

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

if (! function_exists('get_db_property_id')) {
    /**
     * Gets the ID from a table and column based on a term
     *
     * @param        $term
     * @param        $table
     * @param string $column
     * @return null
     */
    function get_db_property_id($term, $table, $column = 'name') {

        $result = \Illuminate\Support\Facades\DB::table($table)
            ->where($column, $term)
            ->first();

        if ($result) {
            return $result->id;
        }
        return null;
    }
}

if (! function_exists('ddd')) {
    /**
     * Adds file and line to the traditional die and dump function
     */
    function ddd() {
        $from = debug_backtrace()[0];
        $args = func_get_args();
        array_push($args, $from['file'] . ":" . $from['line']);
        array_push($args, ['trace' => debug_backtrace()]);

        call_user_func_array('dd', $args);
    }
}

if (! function_exists('remove_spaces')) {
    /**
     * Removes any spaces from the given string
     *
     * @param $string
     * @return mixed|string
     */
    function remove_spaces($string) {
        $string = preg_replace('/\s+/', '', trim($string));

        return $string;
    }
}

