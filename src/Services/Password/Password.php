<?php

namespace Midnite81\LaravelBase\Services\Password;

use Midnite81\LaravelBase\Services\Nato;

class Password
{
    protected $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Return string to lower
     *
     * @return string
     */
    public function toLower()
    {
        return strtolower($this->password);
    }

    /**
     * Return bcrypt version
     *
     * @return string
     */
    public function toBcrypt()
    {
        return bcrypt($this->password);
    }

    /**
     * Base 64 encoded
     *
     * @return string
     */
    public function toBase64()
    {
        return base64_encode($this->password);
    }

    public function toNato()
    {
        return new Nato($this->password);
    }

    public function __toString()
    {
        return $this->password;
    }
}