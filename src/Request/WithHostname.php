<?php

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class WithHostname
 * @package Jigius\Httpcli\Request
 */
final class WithHostname implements RequestInterface
{
    /**
     * @var RequestInterface
     */
    private $orig;

    /**
     * @var string
     */
    private $h;

    /**
     * WithHostname constructor.
     * @param RequestInterface $req
     * @param string $hostname
     */
    public function __construct(RequestInterface $req, string $hostname)
    {
        $this->orig = $req;
        $this->h = $hostname;
    }

    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string
    {
        return $this->orig->sent(
            $client->withHostname($this->h)
        );
    }
}
