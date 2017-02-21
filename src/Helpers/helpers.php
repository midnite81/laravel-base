<?php

namespace Midnite81\Helpers;

/**
 * Concatenate strings together
 *
 * @return string
 */
function concatinate()
{
    $args = func_get_args();
    if (! empty($args)) {
        foreach($args as $key=>$arg) {
            if (is_object($args) || is_array($arg)) {
                unset($args[$key]);
            }
        }
    }
    return implode('', $args);
}

/**
 * Concatenate strings with specified separator as first argument
 *
 * @return string
 */
function concatinate_with_separator()
{
        $args = func_get_args();
        $separator = (isset($args[0])) ? $args[0] : ' ';
        unset($args[0]);
        if (! empty($args)) {
            foreach($args as $key=>$arg) {
                if (is_object($args) || is_array($arg)) {
                    unset($args[$key]);
                }
            }
        }
        return implode($separator, $args);
}