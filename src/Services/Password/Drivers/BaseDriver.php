<?php

namespace Midnite81\LaravelBase\Services\Password\Drivers;

abstract class BaseDriver
{
    abstract public function get();

    /**
     * Convert string to special characters
     *
     * @param $string
     * @return mixed
     */
    public function convertToSpecial($string)
    {
        $searchReplace = [
            'B' => 8,
            'E' => 3,
            'I' => 1,
        ];

        return str_replace(array_keys($searchReplace), array_values($searchReplace), $string);
    }
}