<?php
/*
 * This file is part of the jigius/drom-ads project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 *
 * @copyright Copyright (c) 2022 Jigius <jigius@gmail.com>
 * @link https://github.com/jigius/drom-ads GitHub
 */

namespace Jigius\Httpcli;

use InvalidArgumentException;

final class Header implements HeaderInterface
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
    public function withName(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['name'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withValue(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['value'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     * @InvalidArgumentException
     */
    public function name(): string
    {
        if (!isset($this->i['name'])) {
            throw new InvalidArgumentException("`name` is not defined");
        }
        return $this->i['name'];
    }
    
    /**
     * @inheritDoc
     */
    public function value(): string
    {
        if (empty($this->i['value'])) {
            throw new InvalidArgumentException("`value` is not defined");
        }
        return $this->i['value'];
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
