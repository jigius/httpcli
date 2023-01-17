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

namespace Jigius\Httpcli;

/**
 * Trivial implementation URI contract
 */
final class Uri implements UriInterface
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
    public function withScheme(string $txt): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['scheme'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHostName(string $txt): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['hostname'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withLogin(string $txt): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['login'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withPassword(string $txt): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['password'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withPort(int $n): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['port'] = $n;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withPath(string $txt): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['path'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withParams(array $params): UriInterface
    {
        $that = $this->blueprinted();
        $that->i['params'] = $params;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function uri(): string
    {
        $res = [];
        if (isset($this->i['scheme'])) {
            $res[] = $this->i['scheme'];
            $res[] = "://";
        }
        if (isset($this->i['login'])) {
            $res[] = $this->i['login'];
            if ($this->i['password']) {
                $res[] = ":{$this->i['password']}";
            }
            $res[] = "@";
        }
        if (isset($this->i['hostname'])) {
            $res[] = $this->i['hostname'];
        }
        if (isset($this->i['port'])) {
            $res[] = ":{$this->i['port']}";
        }
        if (isset($this->i['path'])) {
            $res[] = $this->i['path'];
        }
        if (!empty($this->i['params'])) {
            $res[] = "?";
            $res[] = implode("&", $this->i['params']);
        }
        return implode("", $res);
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
