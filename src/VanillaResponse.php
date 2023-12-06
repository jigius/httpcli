<?php

namespace Jigius\Httpcli;

use LogicException;

/**
 * Class VanillaResponse
 * @package Jigius\Httpcli
 */
final class VanillaResponse implements ResponseInterface
{
    /**
     * @var string|null
     */
    private $i;

    /**
     * VanillaResponse constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function content(): string
    {
        if (!isset($this->i)) {
            throw new LogicException("is not assigned yet");
        }
        return $this->i;
    }

    /**
     * @param mixed $input
     * @return ResponseInterface
     */
    public function with($input): ResponseInterface
    {
        $that = new self();
        $that->i = $input;
        return $that;
    }
}
