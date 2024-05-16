<?php


namespace App\Core\Console;

use App\Core\Helpers\Arr;

class ConsoleColor
{
    const COLOR_RED = 1;
    const COLOR_GREEN = 2;
    const COLOR_YELLOW = 3;
    const COLOR_BLUE = 4;
    const COLOR_MAGENTA = 5;
    const COLOR_CYAN = 6;
    const COLOR_LIGHT_GREY = 7;
    const COLOR_DARK_GREY = 8;
    const COLOR_LIGHT_RED = 9;
    const COLOR_LIGHT_GREEN = 10;
    const COLOR_LIGHT_YELLOW = 12;
    const COLOR_LIGHT_BLUE = 13;
    const COLOR_LIGHT_MAGENTA = 14;

    const COLORS = [
        self::COLOR_RED => "\033[31m",
        self::COLOR_GREEN => "\033[32m",
        self::COLOR_YELLOW => "\033[33m",
        self::COLOR_BLUE => "\033[34m",
        self::COLOR_MAGENTA => "\033[35m",
        self::COLOR_CYAN => "\033[36m",
        self::COLOR_LIGHT_GREY => "\033[37m",
        self::COLOR_DARK_GREY => "\033[37m",
        self::COLOR_LIGHT_RED => "\033[91m",
        self::COLOR_LIGHT_GREEN => "\033[92m",
        self::COLOR_LIGHT_YELLOW => "\033[93m",
        self::COLOR_LIGHT_BLUE => "\033[94m",
        self::COLOR_LIGHT_MAGENTA => "\033[95m",
    ];

    public static function color($content, $color = null): string
    {
        $colorFooter = "\033[0m";

        return Arr::get(self::COLORS, $color, '') . $content . $colorFooter;
    }
}
