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

use InvalidArgumentException;

/**
 * Url instance
 */
final class Url implements ParsedUrlInterface
{
    /**
     * @var UriInterface
     */
    private UriInterface $uri;
    
    /**
     * Cntr
     */
    public function __construct(?UriInterface $uri = null)
    {
        $this->uri = $uri ?? new Uri();
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function parsed(string $url): UriInterface
    {
        if (($i = parse_url($url)) === false) {
            throw new InvalidArgumentException("seriously malformed URL");
        }
        $uri = $this->uri;
        if (!empty($i['scheme'])) {
            $uri = $uri->withScheme($i['scheme']);
        }
        if (!empty($i['host'])) {
            $uri = $uri->withHostName($i['host']);
        }
        if (!empty($i['port'])) {
            $uri = $uri->withPort($i['port']);
        }
        if (!empty($i['user'])) {
            $uri = $uri->withLogin($i['user']);
        }
        if (!empty($i['pass'])) {
            $uri = $uri->withPassword($i['pass']);
        }
        if (!empty($i['path'])) {
            $uri = $uri->withPath($i['path']);
        }
        if (!empty($i['query'])) {
            $uri = $uri->withParams(explode("&", $i['query']));
        }
        /*if (!empty($i['fragment'])) {
        }*/
        return $uri;
    }
}