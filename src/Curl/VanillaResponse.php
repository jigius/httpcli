<?php

namespace Jigius\Httpcli\Curl;

use LogicException;

/**
 * Class VanillaResponse
 * @package Jigius\Httpcli
 */
final class VanillaResponse implements ResponseInterface
{
    /**
     * @var array
     */
    private array $i;

    /**
     * VanillaResponse constructor.
     */
    public function __construct()
    {
        $this->i = [];
    }
    
    /**
     * @inheritDoc
     */
    public function content(): string
    {
        if (!isset($this->i)) {
            throw new LogicException("is not assigned yet");
        }
        return $this->i['bytes'];
    }
    
    /**
     * @inheritDoc
     */
    public function withContent(string &$streamOfBytes): self
    {
        $that = $this->blueprinted();
        $that->i['bytes'] = &$streamOfBytes;
        return $that;
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = $this->blueprinted();
        $that->i = $this->i;
        return $that;
    }
}
