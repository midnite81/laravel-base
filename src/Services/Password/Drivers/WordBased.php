<?php
namespace Midnite81\LaravelBase\Services\Password\Drivers;

use Midnite81\LaravelBase\Contracts\Services\Password\PasswordDriver;
use Midnite81\LaravelBase\Services\Password\Dictionary;
use Midnite81\LaravelBase\Services\Password\Password;

class WordBased extends BaseDriver
{
    /**
     * @var string
     */
    protected $object;

    /**
     * @var string
     */
    protected $colour;

    /**
     * @var string
     */
    protected $number;

    /**
     * @var bool
     */
    protected $useSpecial;

    /**
     * WordBased constructor.
     *
     * @param bool $useSpecial
     */
    public function __construct($useSpecial = false)
    {
        $objects = array_merge(Dictionary::animals(), Dictionary::objects());
        $colours = array_merge(Dictionary::colours());
        $this->object = $objects[rand(0, count($objects) - 1)];
        $this->colour = $colours[rand(0, count($colours) - 1)];
        $this->number = $number = str_pad(rand(0, 99), 2, "0", STR_PAD_LEFT);
        $this->useSpecial = $useSpecial;
    }

    /**
     * Return the word based password
     *
     * @return string
     */
    public function get()
    {
        $response = ucfirst($this->colour) . ucfirst($this->object) . "!" . $this->number;

        if ($this->useSpecial) {
            $response = $this->convertToSpecial($response);
        }

        return new Password($response);
    }
}