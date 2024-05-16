<?php

namespace App\Classes\Senders;

use App\Classes\Senders\Instances\ConsoleSender;
use App\Classes\Senders\Instances\FileSender;
use App\Classes\Senders\Instances\Senders;

class SenderFactory
{
    protected static array $senders = [
        'file' => FileSender::class,
        'console' => ConsoleSender::class,
    ];

    public static function make(string $type): Senders
    {
        if (!array_key_exists($type, static::$senders)) {
            throw new \InvalidArgumentException("Sender {$type} not found");
        }

        return new static::$senders[$type];
    }
}