<?php

namespace Midnite81\LaravelBase\Services\Password;

use Midnite81\LaravelBase\Services\Password\Drivers\BaseDriver;
use Midnite81\LaravelBase\Services\Password\Drivers\WordBased;

class Passworder
{
    /**
     * @var null
     */
    protected $driver;

    /**
     * Passworder constructor.
     *
     * @param BaseDriver $driver
     */
    public function __construct(BaseDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Return the generated password
     *
     * @return mixed
     */
    public function generate()
    {
        return $this->driver->get();
    }

    /**
     * Factory Create Method
     *
     * @param bool $useSpecial
     * @return mixed
     */
    public static function createWordBasedPassword($useSpecial = false)
    {
        /** @var $passworder */
        $passworder = new static(new WordBased($useSpecial));

        return $passworder->generate();
    }

    public static function createRandomPassword()
    {
        /** @var $passworder */
        $passworder = new static(new WordBased($useSpecial));

        return $passworder->generate();
    }
}