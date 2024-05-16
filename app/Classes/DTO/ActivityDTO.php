<?php

namespace App\Classes\DTO;

use App\Core\Helpers\Arr;

class ActivityDTO
{
    public string $activity;
    public string $type;
    public int $participants;
    public float $price;
    public string $link;
    public string $key;
    public float $accessibility;

    public function __construct(array $data)
    {
        $this->activity = Arr::get($data, 'activity');
        $this->type = Arr::get($data, 'type');
        $this->participants = Arr::get($data, 'participants');
        $this->price = Arr::get($data, 'price');
        $this->link = Arr::get($data, 'link');
        $this->key = Arr::get($data, 'key');
        $this->accessibility = Arr::get($data, 'accessibility');
    }

    public function getFormatMessage(): string
    {
        return date('Y-m-d H:i:s') . ' -->  Advice: ' . PHP_EOL
            . '  Activity: ' . $this->activity . PHP_EOL
            . '  Type: ' . $this->type . PHP_EOL
            . '  Participants: ' . $this->participants . PHP_EOL
            . '  Price: ' . $this->price . PHP_EOL
            . '  Link: ' . $this->link . PHP_EOL
            . '  Key: ' . $this->key . PHP_EOL
            . '  Accessibility: ' . $this->accessibility . PHP_EOL
            . PHP_EOL;
    }
}