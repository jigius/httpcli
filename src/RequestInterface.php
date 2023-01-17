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
 * Contract Request
 */
interface RequestInterface
{
    /**
     * Does a request
     * @return ResponseInterface
     */
    public function processed(): ResponseInterface;
    
    /**
     * Defines headers for URL is going to request
     * @param HeadersInterface $hdrs
     * @return RequestInterface
     */
    public function withHeaders(HeadersInterface $hdrs): RequestInterface;
    
    /**
     * Returns defined headers
     * @return HeadersInterface
     */
    public function headers(): HeadersInterface;
    
    /**
     * Defines URI is using for a request
     * @param UriInterface $uri
     * @return RequestInterface
     */
    public function withUri(UriInterface $uri): RequestInterface;
    
    /**
     * Returns a current URI instance
     * @return UriInterface
     */
    public function uri(): UriInterface;
}
