<?php


namespace App\Core\Console;


interface ConsoleOutputs
{
    public function print($text, $color = null): void;
    public function printInfo($text): void;
    public function printError($text): void;
    public function printWarning($text): void;
}
