<?php

if ( ! function_exists('console_write')) {
    /**
     * Write a line to the console
     *
     * @param $string
     */
    function console_write($string)
    {
        if (class_exists('Symfony\Component\Console\Output\ConsoleOutput')) {
            $output = new Symfony\Component\Console\Output\ConsoleOutput();
            $output->writeln($string);
        }
    }
}
