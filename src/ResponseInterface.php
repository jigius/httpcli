<?php

namespace Jigius\Httpcli;

/**
 * Interface ResponseInterface
 * @package Jigius\Httpcli
 */
interface ResponseInterface
{
    /**
     * Returns a body of a response
     * @return string
     */
    public function body(): string;
    
    /**
     * Returns headers od a response
     * @return HeadersInterface
     */
    public function headers(): HeadersInterface;
    
    /**
     * Returns the CURL handler has been used for a request
     * @return resource
     */
    public function handler();
}
