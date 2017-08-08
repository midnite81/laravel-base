<?php

if ( ! function_exists('uuid')) {
    /**
    * Generate a new UUID.
    *
    * @return string
    */
    function uuid()
    {
        return app('App\Contracts\Services\UuidGenerator')->generate();
    }
}