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
 * Defines contract for instances that capable represents set of HTTP-headers
 */
interface HeadersInterface
{
    /**
     * Iterates headers and calling a specified function for each of them
     * @param callable $callee
     * @return void
     */
    public function each(callable $callee): void;
    
    /**
     * Returns the sign if a header with a given name is exist or not
     * @param string $name
     * @return bool
     */
    public function existed(string $name): bool;
    
    /**
     * Returns the sign if there are several header with a given name or not
     * @param string $name
     * @return bool
     */
    public function multiple(string $name): bool;
    
    /**
     * Returns all headers with a given name
     * @param string $name
     * @return HeadersInterface
     */
    public function pulled(string $name): HeadersInterface;
    
    /**
     * Returns the first header with a given name
     * @param string $name
     * @return HeaderInterface
     */
    public function fetchOne(string $name): HeaderInterface;
    
    /**
     * Appends a header to the set of headers
     * @param HeaderInterface $h
     * @return HeadersInterface
     */
    public function pushed(HeaderInterface $h): HeadersInterface;
}
