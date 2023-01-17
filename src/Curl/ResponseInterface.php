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

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;

/**
 * Contract for an instance that is capable to store data that
 * has been gotten on a request with using of CURL-library
 */
interface ResponseInterface extends Httpcli\ResponseInterface
{
    /**
     * Defines the content of a body
     * @param string $streamOfBytes
     * @return ResponseInterface
     */
    public function withBody(string &$streamOfBytes): ResponseInterface;
    
    /**
     * Defines headers of a response
     * @param Httpcli\HeadersInterface $hdrs
     * @return ResponseInterface
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): ResponseInterface;
}
