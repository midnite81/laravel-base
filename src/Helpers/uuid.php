<?php

if ( ! function_exists('uuid')) {
    /**
    * Generate a new UUID.
    *
    * @return string
    */
    function uuid()
    {
        return app('Midnite81\Contracts\Services\UuidGenerator')->generate();
    }
}