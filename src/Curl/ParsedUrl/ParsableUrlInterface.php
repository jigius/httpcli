<?php

namespace Jigius\Httpcli\Curl\ParsedUrl;

use Jigius\Httpcli\Curl;

/**
 * Contract that make capable create Request instances from url string
 */
interface ParsableUrlInterface
{
    public function request(string $url): Curl\RequestInterface;
}
