<?php

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
     * @return mixed
     */
    public function withHeader(string $header);

    /**
     * Adds an option to the set of options
     * @param string $name
     * @param $val
     * @return mixed
     */
    public function withOption(string $name, $val);

    /**
     * Executes a request to a resource and returns response as plain text
     * @return string
     */
    public function execute(): string;

    /**
     * Defines an uri for requesting resource
     * @param string $uri
     * @return mixed
     */
    public function withUri(string $uri);

    /**
     * Defines a hostname for requesting resource
     * @param string $hostname
     * @return mixed
     */
    public function withHostname(string $hostname);

    /**
     * Adds additional param for the request part of the uri
     * @param string $name
     * @param string $val
     * @return mixed
     */
    public function withUriParam(string $name, string $val);
}
