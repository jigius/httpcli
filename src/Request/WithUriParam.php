<?php

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class WithUriParam
 * @package Jigius\Httpcli\RequestInterface
 */
final class WithUriParam implements RequestInterface
{
    /**
     * @var RequestInterface
     */
    private $orig;

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $val;

    /**
     * WithOption constructor.
     * @param RequestInterface $req
     * @param string $name
     * @param mixed $val
     */
    public function __construct(RequestInterface $req, string $name, $val)
    {
        $this->orig = $req;
        $this->name = $name;
        $this->val = $val;
    }

    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string
    {
        return $this->orig->sent(
            $client->withUriParam($this->name, $this->val)
        );
    }
}
