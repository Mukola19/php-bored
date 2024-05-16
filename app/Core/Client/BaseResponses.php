<?php


namespace App\Core\Client;


interface BaseResponses
{
    public function getBody(): ?string;

    public function getHeaders(): array;

    public function getStatusCode(): int;
}
