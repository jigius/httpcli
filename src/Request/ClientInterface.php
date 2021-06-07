<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Request;

/**
 * Interface ClientInterface
 * @package Jigius\Httpcli\Request
 */
interface ClientInterface
{
    /**
     * Adds a header to the set of headers
     * @param string $header
     * @return ClientInterface
     */
    public function withHeader(string $header): ClientInterface;

    /**
     * Adds an option to the set of options
     * @param string $name
     * @param $val
     * @return ClientInterface
     */
    public function withOption(string $name, $val): ClientInterface;

    /**
     * Executes a request to a resource and returns response as plain text
     * @return string
     */
    public function execute(): string;

    /**
     * Defines an uri for requesting resource
     * @param string $uri
     * @return ClientInterface
     */
    public function withUri(string $uri): ClientInterface;

    /**
     * Defines a hostname for requesting resource
     * @param string $hostname
     * @return ClientInterface
     */
    public function withHostname(string $hostname): ClientInterface;

    /**
     * Adds additional param for the request part of the uri
     * @param string $name
     * @param string $val
     * @return ClientInterface
     */
    public function withUriParam(string $name, string $val): ClientInterface;
}
