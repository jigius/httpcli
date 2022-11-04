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
     * Defines the content of a body
     * @param string $streamOfBytes
     * @return ResponseInterface
     */
    public function withBody(string &$streamOfBytes): ResponseInterface;
    
    /**
     * Defines headers of a response
     * @param Type\HeadersInterface $hdrs
     * @return ResponseInterface
     */
    public function withHeaders(Type\HeadersInterface $hdrs): ResponseInterface;
    
    /**
     * Defines the code of a response
     * @param resource $ch
     * @return ResponseInterface
     */
    public function withHandler($ch): ResponseInterface;
}
