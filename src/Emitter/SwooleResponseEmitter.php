<?php

namespace App\Emitter;

use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \Swoole\Http\Response $swooleResponse
 */
class SwooleResponseEmitter implements EmitterInterface
{
    /**
     * @param \Swoole\Http\Response $swooleResponse
     */
    public function __construct(\Swoole\Http\Response $swooleResponse)
    {
        $this->swooleResponse = $swooleResponse;
    }

    /**
     * Emit the CakePHP using swoole response
     */
    public function emit(ResponseInterface $response): bool
    {
        if ($response->getStatusCode() === 302) {
            $this->swooleResponse->redirect($response->getHeader('Location')[0] ?? '');

            return true;
        }
        foreach ($response->getHeaders() as $key => $value ){
            $this->swooleResponse->setHeader($key, $value);
        }
        //For now, only need to send html
        $this->swooleResponse->end((string)$response->getBody());

        return true;
    }
}
