<?php

namespace App\Classes\Senders\Instances;

use App\Classes\DTO\ActivityDTO;

abstract class Sender implements Senders
{
    protected ?string $message = null;

    public abstract function handle(ActivityDTO $activityDTO): void;


    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): string
    {
        return $this->message = $message;
    }
}