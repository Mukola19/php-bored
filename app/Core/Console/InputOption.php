<?php


namespace App\Core\Console;


class InputOption
{
    private string $name;
    private $default;

    public function __construct(string $name, $default = null)
    {
        if (substr($name, 0, 2) === "--") {
            $name = substr($name, 2);
        }

        $this->name = $name;
        $this->default = $default;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault()
    {
        return $this->default;
    }
}
