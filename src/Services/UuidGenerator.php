<?php

namespace Midnite81\LaravelBase\Services;

use Midnite81\LaravelBase\Contracts\Services\UuidGenerator as Contract;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements Contract
{
    /**
     * Generate a new UUID.
     *
     * @return string
     */
    public function generate()
    {
        return Uuid::uuid4()->toString();
    }
}