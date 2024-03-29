<?php

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class WithHeader
 * @package Jigius\Httpcli\Request
 */
final class WithHeader implements RequestInterface
{
    /**
     * @var RequestInterface RequestInterface
     */
    private $orig;

    /**
     * @var string
     */
    private $h;

    /**
     * WithHeader constructor.
     * @param RequestInterface $req
     * @param string $header
     */
    public function __construct(RequestInterface $req, string $header)
    {
        $this->orig = $req;
        $this->h = $header;
    }

    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string
    {
        return $this->orig->sent(
            $client->withHeader($this->h)
        );
    }
}
