<?php


namespace App\Core\Console;


class ConsoleOutput implements ConsoleOutputs
{
    public function print($text, $color = null): void
    {
        $text = print_r($text, 1);

        print_r( ConsoleColor::color($text, $color) . PHP_EOL);
    }

    public function printInfo($text): void
    {
        $this->print($text, ConsoleColor::COLOR_CYAN);
    }

    public function printError($text): void
    {
        $this->print($text, ConsoleColor::COLOR_LIGHT_RED);
    }

    public function printWarning($text): void
    {
        $this->print($text, ConsoleColor::COLOR_LIGHT_YELLOW);
    }
}
