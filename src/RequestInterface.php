<?php

namespace Jigius\Httpcli;

use Jigius\Httpcli\Request\ClientInterface;

/**
 * Interface RequestInterface
 * @package Jigius\Httpcli
 */
interface RequestInterface
{
    /**
     * @param ClientInterface $client
     * @return string
     */
    public function sent(ClientInterface $client): string;
}
