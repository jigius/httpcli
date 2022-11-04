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
     * @return ResponseInterface
     */
    public function processed(): ResponseInterface;
}
