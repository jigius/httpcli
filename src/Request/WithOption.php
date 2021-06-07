<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class WithOption
 * @package Jigius\Httpcli\Request
 */
final class WithOption implements RequestInterface
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $orig;

    /**
     * @var string
     */
    private string $name;

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
            $client->withOption($this->name, $this->val)
        );
    }
}
