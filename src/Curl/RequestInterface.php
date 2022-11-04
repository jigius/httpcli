<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;

/**
 * Contract for an instance that is capable to do requests with using of CURL-library
 */
interface RequestInterface extends Httpcli\RequestInterface
{
    /**
     * Defines headers for URL is going to request
     * @param Httpcli\HeadersInterface $hdrs
     * @return RequestInterface
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): RequestInterface;
    
    /**
     * Defines a scheme for URL is going to request
     * @param string $txt
     * @return RequestInterface
     */
    public function withScheme(string $txt): RequestInterface;
    
    /**
     * Defines a hostname for URL is going to request
     * @param string $txt
     * @return RequestInterface
     */
    public function withHostName(string $txt): RequestInterface;
    
    /**
     * Defines a login for URL is going to request
     * @param string $txt
     * @return RequestInterface
     */
    public function withLogin(string $txt): RequestInterface;
    
    /**
     * Defines a password for URL is going to request
     * @param string $txt
     * @return RequestInterface
     */
    public function withPassword(string $txt): RequestInterface;
    
    /**
     * Defines a port for URL is going to request
     * @param int $n
     * @return RequestInterface
     */
    public function withPort(int $n): RequestInterface;
    
    /**
     * Defines a path for URL is going to request
     * @param string $txt
     * @return RequestInterface
     */
    public function withPath(string $txt): RequestInterface;
    
    /**
     * Defines params for URL is going to request
     * @param array $params
     * @return RequestInterface
     */
    public function withParams(array $params): RequestInterface;
    
    /**
     * Defines a CURL-handler
     * @param $curl resource
     * @return RequestInterface
     */
    public function withHandler($curl): RequestInterface;
}
