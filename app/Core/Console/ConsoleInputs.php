<?php


namespace App\Core\Console;


interface ConsoleInputs
{
    public function getOptions(): array;

    public function getFirstArgument();
}
