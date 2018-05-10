<?php

namespace Midnite81\LaravelBase\Traits;

trait Instantiate
{
    /**
     * Return an instance of the model
     *
     * @return static
     * @throws \ReflectionException
     */
    public static function instance()
    {
        $instance = new \ReflectionClass(static::class);
        return $instance->newInstanceArgs(func_get_args());
    }
}