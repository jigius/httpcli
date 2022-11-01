<?php

namespace Jigius\Httpcli;

/**
 * Interface RequestInterface
 * @package Jigius\Httpcli
 */
interface RequestInterface
{
    /**
     * @return ResponseInterface
     */
    public function processed(): ResponseInterface;
}
