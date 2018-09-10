<?php

namespace Midnite81\LaravelBase\Services;

class Input
{
    public static function addCheckboxData(array &$data, array $refine)
    {
        foreach($refine as $item)  {
            $data[$item] = ! empty($data[$item]);
        }
    }
}