<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;

/**
 * Interface ResponseInterface
 * @package Jigius\Httpcli
 */
interface ResponseInterface extends Httpcli\ResponseInterface
{
    /**
     * Defines the content of a body
     * @param string $streamOfBytes
     * @return ResponseInterface
     */
    public function withBody(string &$streamOfBytes): ResponseInterface;
    
    /**
     * Defines headers of a response
     * @param Httpcli\HeadersInterface $hdrs
     * @return ResponseInterface
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): ResponseInterface;
    
    /**
     * Defines the code of a response
     * @param resource $ch
     * @return ResponseInterface
     */
    public function withHandler($ch): ResponseInterface;
    
    /**
     * Returns the CURL handler has been used for a request
     * @return resource
     */
    public function handler();
}
