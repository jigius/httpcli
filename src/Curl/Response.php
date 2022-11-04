<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli\HeadersInterface;
use InvalidArgumentException;

/**
 * Class Response
 * @package Jigius\Httpcli
 */
final class Response implements ResponseInterface
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
     * @throws InvalidArgumentException
     */
    public function body(): string
    {
        if (!isset($this->i)) {
            throw new InvalidArgumentException("`body` is not defined");
        }
        return $this->i['body'];
    }
    
    /**
     * @inheritDoc
     */
    public function withBody(string &$streamOfBytes): self
    {
        $that = $this->blueprinted();
        $that->i['body'] = &$streamOfBytes;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHandler($ch): self
    {
        $that = $this->blueprinted();
        $that->i['curl'] = $ch;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHeaders(HeadersInterface $hdrs): self
    {
        $that = $this->blueprinted();
        $that->i['hdrs'] = $hdrs;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function handler()
    {
        if (!isset($this->i['curl'])) {
            throw new InvalidArgumentException("`handler` is not defined");
        }
        return $this->i['curl'];
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function headers(): HeadersInterface
    {
        if (!isset($this->i['headers'])) {
            throw new InvalidArgumentException("`headers` are not defined");
        }
        return $this->i['headers'];
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
