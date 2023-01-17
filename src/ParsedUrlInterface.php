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
 * Makes capable to get uri instance from an url is expressed via string
 */
interface ParsedUrlInterface
{
    /**
     * @param string $url
     * @return UriInterface
     */
    public function parsed(string $url): UriInterface;
}
