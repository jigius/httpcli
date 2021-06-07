<?php
declare(strict_types=1);

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
    private RequestInterface $orig;

    /**
     * @var string
     */
    private string $h;

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

