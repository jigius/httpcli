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

use UnexpectedValueException;

final class Headers implements HeadersInterface
{
    /**
     * @var array
     */
    private array $coll;
    /**
     * @var array
     */
    private array $idx;
    
    /**
     * Cntr
     */
    public function __construct()
    {
        $this->coll = [];
        $this->idx = [];
    }
    
    /**
     * @inheritDoc
     * If a function returns false - the iterating is broken
     */
    public function each(callable $callee): void
    {
        foreach ($this->coll as $h) {
            if (call_user_func($callee, $h) === false) {
                break;
            }
        }
    }
    
    /**
     * @inheritDoc
     */
    public function existed(string $name): bool
    {
        return array_key_exists($this->key($name), $this->idx);
    }
    
    /**
     * @inheritDoc
     * @throws UnexpectedValueException
     */
    public function pulled(string $name): HeadersInterface
    {
        $hdrs = new self();
        if (!$this->existed($name)) {
            throw new UnexpectedValueException("name=`$name` is unknown");
        }
        foreach ($this->idx[$this->key($name)] as $idx) {
            $hdrs = $hdrs->pushed($this->coll[$idx]);
        }
        return $hdrs;
    }
    
    /**
     * @inheritDoc
     */
    public function pushed(HeaderInterface $h): self
    {
        $that = $this->blueprinted();
        $key = $this->key($h->name());
        $that->coll[] = $h;
        if (!$this->existed($h->name())) {
            $that->idx[$key] = [];
        }
        $that->idx[$key][] = count($this->coll);
        return $that;
    }
    
    /**
     * @inheritDoc
     * @throws UnexpectedValueException
     */
    public function multiple(string $name): bool
    {
        if (!$this->existed($name)) {
            throw new UnexpectedValueException("name=`$name` is unknown");
        }
        return count($this->idx[$this->key($name)]) > 1;
    }
    
    /**
     * @inheritDoc
     * @throws UnexpectedValueException
     */
    public function fetchOne(string $name): HeaderInterface
    {
        if (!$this->existed($name)) {
            throw new UnexpectedValueException("name=`$name` is unknown");
        }
        return $this->coll[$this->idx[$this->key($name)][0]];
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->coll = $this->coll;
        $that->idx = $this->idx;
        return $that;
    }
    
    /**
     * Returns a unique string is corresponded to a specified string
     * @param string $name
     * @return string
     */
    private function key(string $name): string
    {
        return hash("md5", strtolower($name));
    }
}
