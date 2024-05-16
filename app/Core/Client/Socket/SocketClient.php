<?php

namespace App\Core\Client\Socket;

use Exception;

class SocketClient
{
    private array $sysErr = ['no' => null, 'msg' => null];
    public int $port = 80;
    protected SocketRequest $request;

    public function __construct(SocketRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    private function socket()
    {
        $socket = fsockopen(
            ($this->request->scheme == 'https' ? 'ssl://' : '') . $this->request->host,
            ($this->request->scheme == 'https' ? 443 : $this->port),
            $this->sysErr['no'],
            $this->sysErr['msg'], 3
        );

        if (!$socket) {
            throw new Exception("Error while trying to connect to the host: " . $this->sysErr['msg']);
        }

        return $socket;
    }

    public function send(): SocketResponse
    {
        try {
            $socket = $this->socket();

            fwrite($socket, $this->request->getRawRequest());

            $response = SocketResponse::parserFromStream($socket);
            fclose($socket);

            return $response;
        } catch (Exception $exception) {
            return new SocketResponse();
        }
    }
}