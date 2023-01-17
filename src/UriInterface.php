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
 * URI contract
 */
interface UriInterface
{
    /**
     * Defines a scheme for URI is going to request
     * @param string $txt
     * @return UriInterface
     */
    public function withScheme(string $txt): UriInterface;
    
    /**
     * Defines a hostname for URI is going to request
     * @param string $txt
     * @return UriInterface
     */
    public function withHostName(string $txt): UriInterface;
    
    /**
     * Defines a login for URI is going to request
     * @param string $txt
     * @return UriInterface
     */
    public function withLogin(string $txt): UriInterface;
    
    /**
     * Defines a password for URI is going to request
     * @param string $txt
     * @return UriInterface
     */
    public function withPassword(string $txt): UriInterface;
    
    /**
     * Defines a port for URI is going to request
     * @param int $n
     * @return UriInterface
     */
    public function withPort(int $n): UriInterface;
    
    /**
     * Defines a path for URI is going to request
     * @param string $txt
     * @return UriInterface
     */
    public function withPath(string $txt): UriInterface;
    
    /**
     * Defines params for URI is going to request
     * @param array $params
     * @return UriInterface
     */
    public function withParams(array $params): UriInterface;
    
    /**
     * Returns URI as a string
     * @return string
     */
    public function uri(): string;
}
