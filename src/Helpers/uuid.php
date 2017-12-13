<?php

if ( ! function_exists('uuid')) {
    /**
    * Generate a new UUID.
    *
    * @return string
    */
    function uuid()
    {
        return app('Midnite81\LaravelBase\Contracts\Services\UuidGenerator')->generate();
    }
}