<?php

namespace App\Classes\Senders\Instances;

use App\Classes\DTO\ActivityDTO;

class ConsoleSender extends Sender
{
    public function handle(ActivityDTO $activityDTO): void
    {
        $this->setMessage($activityDTO->getFormatMessage());
    }
}