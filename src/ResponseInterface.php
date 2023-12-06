<?php

namespace Jigius\Httpcli;

/**
 * Interface ResponseInterface
 * @package Jigius\Httpcli
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function content();

    /**
     * @param mixed $input
     * @return ResponseInterface
     */
    public function with($input): ResponseInterface;
}
