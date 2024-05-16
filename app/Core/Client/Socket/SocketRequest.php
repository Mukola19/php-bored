<?php

namespace App\Core\Client\Socket;


class SocketRequest
{
    const CRLF = "\r\n";

    public string $method;
    public string $scheme;
    public string $host;
    public string $uri;
    public array $headers;
    public ?string $body;
    public string $version;
    public string $userAgent = "PHPHttpClient/1.0";


    public function __construct(
        $method,
        $host,
        $uri,
        array $headers = [],
        $body = null,
        string $version = '1.1',
        string $scheme = 'https'
    )
    {
        $this->method = $method;
        $this->host = $host;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->version = $version;
        $this->scheme = $scheme;
    }


    public function getRawRequest(): string
    {
        $rawRequest = $this->method . ' ' . (empty($this->uri) ? '/' : $this->uri) . ' HTTP/' . $this->version . self::CRLF;
        $rawRequest .= 'Host: ' . $this->host . self::CRLF;


        if (!empty($this->body)) {
            $rawRequest .= 'Content-Length: ' . strlen($this->body) . self::CRLF;
        } else {
            unset($this->headers['Content-Length']);
        }

        $this->setHeader('User-Agent', $this->userAgent);

        if (!$this->getHeader('Accept')) {
            $this->setHeader('Accept', '*/*');
        }

//        if ($this->auth_login != false) {
//            $this->setCredentials();
//        }
        if (!$this->getHeader('Connection')) {
            $this->setHeader('Connection', 'close');
        }

//        $this->addCookieHeaders();

        foreach ($this->headers as $name => $val) {
            $rawRequest .= $name . ': ' . $val . self::CRLF;
        }

        $rawRequest .= self::CRLF;

        if (!empty($this->body)) {
            $rawRequest .= $this->body . self::CRLF . self::CRLF;
        }

        return $rawRequest;
    }

    public function setHeader(string $name, string $value)
    {
        if (empty($name)) return;

        $this->headers[str_replace(' ', '-', ucwords(str_replace('-', ' ', $name)))] = $value;
    }

    public function deleteHeader(string $name)
    {
        unset($this->headers[$name]);
    }

    public function hasHeader(string $name): bool
    {
        return array_key_exists($name, $this->headers);
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }
}