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

    public function generate()
    {
        return [
            'pass' => $this->driver->get(),
            'bcrypt' => bcrypt($this->driver->get())
        ];
    }

    /**
     * Factory Create Method
     *
     * @param bool $useSpecial
     * @return mixed
     */
    public function createWordBasedPassword($useSpecial = false)
    {
        /** @var $passworder */
        $passworder = new static(new WordBased($useSpecial));

        $passworder->generate();
    }

    public function createRandomPassword()
    {
        /** @var $passworder */
        $passworder = new static(new WordBased($useSpecial));

        $passworder->generate();
    }
}