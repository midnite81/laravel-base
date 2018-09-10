<?php

namespace Midnite81\LaravelBase\Services;

class Nato
{
    protected $nato = [
        "a" => "Alpha",
        "b" => "Bravo",
        "c" => "Charlie",
        "d" => "Delta",
        "e" => "Echo",
        "f" => "Foxtrot",
        "g" => "Golf",
        "h" => "Hotel",
        "i" => "India",
        "j" => "Juliet",
        "k" => "Kilo",
        "l" => "Lima",
        "m" => "Mike",
        "n" => "November",
        "o" => "Oscar",
        "p" => "Papa",
        "q" => "Quebec",
        "r" => "Romeo",
        "s" => "Sierra",
        "t" => "Tango",
        "u" => "Uniform",
        "v" => "Victor",
        "w" => "Whiskey",
        "x" => "X-Ray",
        "y" => "Yankee",
        "z" => "Zulu",
        "0" => "Zero",
        "1" => "One",
        "2" => "Two",
        "3" => "Three",
        "4" => "Four",
        "5" => "Five",
        "6" => "Six",
        "7" => "Seven",
        "8" => "Eight",
        "9" => "Nine",
        "-" => "Dash",
        " " => "(Space)",
        "." => "(Full Stop)",
        "," => "(Comma)",
        ":" => "(Colon)",
        ";" => "(Semi-Colon)",
        "\"" => "(Double Quote)",
        "'" => "(Single Quote)",
        "|" => "(Pipe)",
        "[" => "(Opening Square Bracket)",
        "]" => "(Closing Square Bracket)",
        "{" => "(Opening Curly Bracket)",
        "}" => "(Closing Curly Bracket)",
        "<" => "(Less Than)",
        ">" => "(Greater Than)",
        "?" => "(Question Mark)",
        "~" => "(Tilda)",
        "`" => "(BackTick)",
        "!" => "(Explanation Mark)",
        "@" => "(At Sign)",
        "£" => "(Pound Sign)",
        "$" => "(Dollar Sign)",
        "%" => "(Percentage)",
        "^" => "(Caret)",
        "&" => "(Ampersand)",
        "*" => "(Asterisk)",
        "(" => "(Opening Bracket)",
        ")" => "(Closing Bracket)",
    ];

    /**
     * Convert to Nato from String
     *
     * @param $string
     * @return string
     */
    public function convertToNato($string)
    {
        $natoReturn = array();

        for($i=0; $i < strlen($string); $i++) {
            $currentLetter=substr($string,$i,1);

            if (! empty($this->nato[$currentLetter])) {
                $natoLetter = strtolower($this->nato[$currentLetter]);
            } else if (! empty($this->nato[strtolower($currentLetter)])) {
                $natoLetter = strtoupper($this->nato[strtolower($currentLetter)]);
            } else {
                $natoLetter = $currentLetter;
            }
            $natoReturn[] = $natoLetter;
        }

        return implode(" ",$natoReturn);
    }

    /**
     * Convert from Nato to String
     *
     * @param $natowords
     * @return string
     */
    public function convertToString($natowords) {
        $natowords = @explode(" ",trim($natowords));
        $natoKeys = array_keys($this->nato);
        $natoreturn = array();

        foreach($natowords as $n) {
            if (in_array(ucwords(strtolower($n)),$this->nato)) {
                $natoreturn[] = array_search(ucwords(strtolower($n)),$this->nato);

            }
            else {
                if (strtolower($n) == "(space)") {
                    $natoreturn[] = " ";
                }
                else {
                    $natoreturn[] = " _" . $n . "_ ";
                }

            }
        }

        return implode("",$natoreturn);
    }

    /**
     * Convert a string to Nato
     *
     * @param $string
     * @return mixed
     */
    public static function convert($string)
    {
        return (new static)->convertToNato($string);
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function reverseConvert($string)
    {
        return (new static)->convertToString($string);
    }
}