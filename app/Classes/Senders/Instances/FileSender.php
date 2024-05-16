<?php

namespace App\Classes\Senders\Instances;

use App\Classes\DTO\ActivityDTO;
use App\Core\Storage\Storage;

class FileSender extends Sender
{
    public function handle(ActivityDTO $activityDTO): void
    {
        $storage = new Storage();

        $storage->putToFile(
            'activity.txt',
            $activityDTO->getFormatMessage()
        );

        $this->setMessage('The answer is written to the file');
    }
}