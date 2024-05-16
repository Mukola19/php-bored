<?php

namespace App\Classes\BoredApi;

use App\Core\Client\HttpClient;
use App\Core\Client\HttpResponse;

class BoredApi
{
    const BASE_URL = 'https://www.boredapi.com';

    public static function getActivity(int $participants, string $type): HttpResponse
    {
        return (new HttpClient(self::BASE_URL . '/api/activity'))
            ->setQueries([
                'participants' => $participants,
                'type' => $type,
            ])
            ->get();
    }
}