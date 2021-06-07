<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Request;

use Jigius\Httpcli\RequestInterface;

/**
 * Class VanillaRequest
 * @package Jigius\Httpcli\Request
 */
final class VanillaRequest implements RequestInterface
{
    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string
    {
        return $client->execute();
    }
}
