<?php

namespace Jigius\Httpcli\Curl;

use LogicException;
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
    public function withCode(int $code): self
    {
        $that = $this->blueprinted();
        $that->i['code'] = $code;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHeaders(array $hdrs): self
    {
        $that = $this->blueprinted();
        $that->i['hdrs'] = $hdrs;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function code(): int
    {
        if (!isset($this->i['code'])) {
            throw new InvalidArgumentException("`code` is not defined");
        }
        return $this->i['code'];
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function headers(): array
    {
        if (!isset($this->i['code'])) {
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
