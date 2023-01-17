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

interface ClientInterface
{
    /**
     * @param int $option
     * @param $value
     * @return ClientInterface
     */
    public function withOption(int $option, $value): ClientInterface;
    
    /**
     * @param Httpcli\HeadersInterface $h
     * @return ClientInterface
     */
    public function withHeaders(Httpcli\HeadersInterface $h): ClientInterface;
    
    /**
     * Returns an instance with a copy of a resource which is used for requests
     * @return ClientInterface
     */
    public function withCopiedConnection(): ClientInterface;
    
    /**
     * @return mixed
     */
    public function execute();
    
    /**
     * @return void
     */
    public function close(): void;
}
