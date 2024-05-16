<?php


namespace App\Core\Client\Socket;

use App\Core\Client\BaseResponses;
use App\Core\Helpers\Arr;

class SocketResponse implements BaseResponses
{
    const CRLF = "\r\n";

    public int $statusCode = 0;
    public string $statusMessage = '';

    public array $headers = [];
    public array $cookies = [];
    protected ?string $body = null;

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public static function parserFromStream($stream): SocketResponse
    {
        $instance = new self();

        $instance->parserStreamResponse($stream);

        return $instance;
    }

    public function parserStreamResponse($stream): void
    {
        if (!$stream) {
            return;
        }

        $inHead = true;
        $i = 0;

        while (!feof($stream)) {
            $line = fgets($stream, 4096);

            if (empty($line) || $line == self::CRLF) {
                $inHead = false;
                continue;
            }
            if ($i == 0) {
                if (!$this->parseStatus($line))
                    return;
                $i++;
                continue;
            }
            $i++;

            if ($inHead) {
                $this->parseHeader($line);

            } else {
                if (strtolower(Arr::get('Transfer-Encoding', $this->headers)) == "chunked") {
                    if (preg_match('/^[0-9a-f]+$/', trim($line)) == 1) {
                        continue;
                    }
                }

                $this->body .= $line;
            }
        }
    }

    private function parseStatus(string $line): bool
    {
        if (preg_match('/^HTTP\/(.)+/', $line) <= 0)
            return false;
        $line = explode(" ", $line);

        $this->statusCode = trim($line[1]);
        $this->statusMessage = trim($line[2]);

        return true;
    }

    private function parseHeader(string $line)
    {
        list($name, $value) = explode(':', trim($line), 2);

        if ($name && $value) {
            $this->headers[trim($name)] = trim($value);
        }
    }
}
