<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli\Curl;
use InvalidArgumentException;

/**
 * Prints out Request instance is constructed from URL-string
 */
final class PrnRequest implements Curl\PrintableRequestInterface
{
    /**
     * @var array
     */
    private array $i;
    
    /**
     * Cntr
     */
    public function __construct()
    {
        $this->i = [];
    }
    
    /**
     * @inheritDoc
     */
    public function with(string $key, $val): self
    {
        $that = $this->blueprinted();
        $that->i[$key] = $val;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function finished(): Curl\RequestInterface
    {
        if (!isset($this->i['url']) || !is_string($this->i['url'])) {
            throw new InvalidArgumentException("`url` is not defined or has an invalid type");
        }
        if (isset($this->i['request']) && !$this->i['request'] instanceof Curl\RequestInterface) {
            throw new InvalidArgumentException("`request` has an invalid type");
        }
        $req = $this->i['request'] ?? new Curl\Request();
        $i = parse_url($this->i['url']);
        if (isset($i['scheme'])) {
            $req = $req->withScheme($i['scheme']);
        }
        if (isset($i['host'])) {
            $req = $req->withHostName($i['host']);
        }
        if (isset($i['port'])) {
            $req = $req->withPort($i['port']);
        }
        if (isset($i['user'])) {
            $req = $req->withLogin($i['user']);
        }
        if (isset($i['pass'])) {
            $req = $req->withPassword($i['pass']);
        }
        if (isset($i['path'])) {
            $req = $req->withPath($i['path']);
        }
        if (isset($i['query'])) {
            $req = $req->withParams(explode("&", $i['query']));
        }
        return $req;
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
