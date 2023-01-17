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
 * Defines contract for instances that capable represents HTTP-header
 */
interface HeaderInterface
{
    /**
     * Defines a name
     * @param string $txt
     * @return HeaderInterface
     */
    public function withName(string $txt): HeaderInterface;
    
    /**
     * Defines a value
     * @param string $txt
     * @return HeaderInterface
     */
    public function withValue(string $txt): HeaderInterface;
    
    /**
     * Returns a header's name
     * @return string
     */
    public function name(): string;
    
    /**
     * Returns the header's value or return the first value if the header is occurred multiple times
     * @return string
     */
    public function value(): string;
}
