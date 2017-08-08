<?php
namespace Midnite81\Contracts\Services;

interface UuidGenerator
{
    /**
     * Generate a new UUID.
     *
     * @return string
     */
    public function generate();

}