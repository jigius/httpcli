<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli as Type;

/**
 * Interface ResponseInterface
 * @package Jigius\Httpcli
 */
interface ResponseInterface extends Type\ResponseInterface
{
    /**
     * @param string $streamOfBytes
     * @return ResponseInterface
     */
    public function withContent(string &$streamOfBytes): ResponseInterface;
}
