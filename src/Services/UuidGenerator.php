<?php

namespace Midnite81\Services;
use Midnite81\Contracts\Services\UuidGenerator as UuidGeneratorContract;
use Ramsey\Uuid\Uuid;


class UuidGenerator implements UuidGeneratorContract
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
