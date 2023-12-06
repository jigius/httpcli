<?php

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class WithUri
 * @package Jigius\Httpcli\Request
 */
final class WithUri implements RequestInterface
{
    /**
     * @var RequestInterface
     */
    private $orig;

    /**
     * @var string
     */
    private $uri;

    /**
     * WithUri constructor.
     * @param RequestInterface $request
     * @param string $uri
     */
    public function __construct(RequestInterface $request, string $uri)
    {
        $this->orig = $request;
        $this->uri = $uri;
    }

    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string
    {
        return $this->orig->sent(
            $client->withUri($this->uri)
        );
    }
}
