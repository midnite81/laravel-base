<?php
namespace Midnite81\LaravelBase\Services\Password\Drivers;

use Midnite81\LaravelBase\Services\Password\Password;

class RandomString extends BaseDriver
{
    protected $charSet = [
        'lower' => 'abcdefghijklmnopqrstuvwxyz',
        'upper' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'number' => '1234567890',
        'special' => '!@$%^&*()',
    ];

    protected $upper;

    protected $lower;

    protected $number;

    protected $special;

    protected $types = ['lower', 'upper', 'number', 'special'];

    protected $characters = [];

    protected $originalCharacters;

    protected $random = [];

    /**
     * @var int
     */
    protected $length;

    /**
     * @var bool
     */
    protected $unique;

    protected $counter = 1;

    /**
     * RandomString constructor.
     *
     * @param int  $length
     * @param bool $unique
     * @param bool $upper
     * @param bool $lower
     * @param bool $number
     * @param bool $special
     */
    public function __construct($length = 12, $unique = true, $upper = true, $lower = true, $number = true, $special = true)
    {
        $this->length = $length;
        $this->unique = $unique;
        $this->upper = $upper;
        $this->lower = $lower;
        $this->number = $number;
        $this->special = $special;
        $this->addCharactersToArray();
    }

    /**
     * Get the generated password
     */
    function get()
    {
        foreach($this->types as $type) {
            if ($this->{$type}) {
                array_push($this->random, $this->getCharacter($type));
            }
        }

        for($i = $this->counter; $i < $this->length; $i++) {
            array_push($this->random,  $this->getCharacterFromArray());
        }

        $randomPassword = str_shuffle(implode('', $this->random));

        return new Password($randomPassword);
    }

    /**
     * Add Characters To Array
     */
    protected function addCharactersToArray()
    {
        foreach ($this->types as $type) {
            if ($this->{$type}) {
                $this->pushToCharacters($type);
                $this->counter++;
            }
        }

        shuffle($this->characters);
        $this->originalCharacters = $this->characters;
    }

    /**
     * Push to Characters
     *
     * @param $property
     */
    protected function pushToCharacters($property)
    {
        if (! empty($this->charSet[$property])) {
            $this->characters = array_merge($this->characters, str_split($this->charSet[$property]));
        }
    }

    /**
     * Get character
     *
     * @param $type
     * @return mixed
     */
    protected function getCharacter($type)
    {
        $character = $this->charSet[$type][rand(0, strlen($this->charSet[$type]) - 1)];

        if ($this->unique) {
            $this->removeFromArray($character);
        }

        return $character;
    }

    /**
     * Get character
     *
     * @return mixed
     */
    protected function getCharacterFromArray()
    {
        $character = $this->characters[rand(0, count($this->characters) - 1)];

        if ($this->unique) {
            $this->removeFromArray($character);
        }

        return $character;
    }

    /**
     * @param $character
     */
    protected function removeFromArray($character)
    {
        $position = array_search($character, $this->characters);
        unset($this->characters[$position]);
        $this->characters = array_values($this->characters);
    }
}