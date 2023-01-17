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
 * Interface ResponseInterface
 * @package Jigius\Httpcli
 */
interface ResponseInterface
{
    /**
     * Returns a body of a response
     * @return string
     */
    public function body(): string;
    
    /**
     * Returns headers od a response
     * @return HeadersInterface
     */
    public function headers(): HeadersInterface;
}
