<?php


namespace App\Core\Client;

use App\Core\Helpers\Arr;

class HttpResponse
{
    protected BaseResponses $response;
    protected array $decoded = [];
    public array $cookies;

    public function __construct(BaseResponses $response)
    {
        $this->response = $response;
    }

    public function body(): string
    {
        return (string)$this->response->getBody();
    }

    public function json($key = null, $default = null)
    {
        if (!$this->decoded) {
            $this->decoded = json_decode($this->body(), true);
        }

        if (is_null($key)) {
            return $this->decoded;
        }

        return Arr::get($this->decoded, $key, $default);
    }

    public function object()
    {
        return json_decode($this->body(), false);
    }

    public function headers(): array
    {
        return $this->response->getHeaders();
    }

    public function status(): int
    {
        return $this->response->getStatusCode();
    }

    public function successful(): bool
    {
        return $this->status() >= 200 && $this->status() < 300;
    }

    public function cookies(): array
    {
        return $this->cookies;
    }

    public function __toString()
    {
        return $this->body();
    }
}
