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
 * Contract for an instance that is capable to do requests with using of CURL-library
 */
interface RequestInterface extends Httpcli\RequestInterface
{
    /**
     * @inheritdoc
     * @return RequestInterface
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): RequestInterface;
    
    /**
     * @inheritdoc
     * @return RequestInterface
     */
    public function withUri(Httpcli\UriInterface $uri): RequestInterface;
    
    /**
     * Defines a client which makes a connection via CURL
     * @param ClientInterface $client
     * @return RequestInterface
     */
    public function withClient(ClientInterface $client): RequestInterface;
    
    /**
     * Returns a current defined client
     * @return ClientInterface
     */
    public function client(): ClientInterface;
    
    /**
     * @inheritdoc
     * @return ResponseInterface
     */
    public function processed(): ResponseInterface;
}
