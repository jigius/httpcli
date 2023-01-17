<?php
/*
 * This file is part of the jigius/httpcli project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 *
 * @copyright Copyright (c) 2022 Jigius <jigius@gmail.com>
 * @link https://github.com/jigius/httpcli GitHub
 */

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;
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
     * @var Httpcli\HeadersInterface
     */
    private Httpcli\HeadersInterface $hdrs;
    
    /**
     * VanillaResponse constructor.
     */
    public function __construct(?Httpcli\HeadersInterface $hdrs = null)
    {
        $this->hdrs = $hdrs ?? new Httpcli\Headers();
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
    public function withHeaders(Httpcli\HeadersInterface $hdrs): self
    {
        $that = $this->blueprinted();
        $that->hdrs = $hdrs;
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
     */
    public function headers(): Httpcli\HeadersInterface
    {
        return $this->hdrs;
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self($this->hdrs);
        $that->i = $this->i;
        return $that;
    }
}
