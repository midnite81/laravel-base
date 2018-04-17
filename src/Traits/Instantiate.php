<?php

namespace Midnite81\LaravelBase\Traits;

trait Instantiate
{
    /**
     * Return an instance of the model
     *
     * @return static
     */
    public static function instance()
    {
        return new static;
    }
}