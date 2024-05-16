<?php

namespace App\Core\Client;


use App\Core\Client\Socket\SocketClient;
use App\Core\Client\Socket\SocketRequest;
use App\Core\Helpers\Arr;

class HttpClient
{
    protected ?string $url;
    protected ?string $scheme;
    protected int $port;
    protected ?string $host;
    protected ?string $uri;
    protected array $queries;
    protected array $headers = [];

    public function __construct($url = null)
    {
        $this->url = $url;

        $parse = parse_url($url);

        $this->scheme = Arr::get($parse, 'scheme');
        $this->host = Arr::get($parse, 'host');
        $this->uri = Arr::get($parse, 'path');
        $this->port = Arr::get($parse, 'port', 80);

        parse_str(Arr::get($parse, 'query'), $queries);
        $this->queries = $queries;
    }

    public function setQueries(array $queries): HttpClient
    {
        $this->queries = array_merge($this->queries, $queries);

        return $this;
    }

    public function get(string $uri = null, array $queries = []): HttpResponse
    {
        $uri = $uri ?: $this->uri;
        $queries = array_merge($this->queries, $queries);

        $uri .= count($queries) ? '?' . http_build_query($queries) : '';

        $request = new SocketRequest(
            'GET',
            $this->host,
            $uri,
            $this->headers
        );

        $socket = new SocketClient($request);

        return new HttpResponse($socket->send());
    }
}