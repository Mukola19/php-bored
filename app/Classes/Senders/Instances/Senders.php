<?php

namespace App\Classes\Senders\Instances;

use App\Classes\DTO\ActivityDTO;

interface Senders
{
    public function handle(ActivityDTO $activityDTO);

    public function getMessage(): ?string;
}