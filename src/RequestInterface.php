<?php

namespace Jigius\Httpcli;

/**
 * Interface RequestInterface
 * @package Jigius\Httpcli
 */
interface RequestInterface
{
    /**
     * Does a request
     * @param ResponseInterface $resp
     * @return ResponseInterface
     */
    public function processed(ResponseInterface $resp): ResponseInterface;
}
