<?php

namespace Jigius\Httpcli\Curl;

use Acc\Core\PrinterInterface;
use Jigius\Httpcli\Curl;

/**
 * Contract that make capable create Request instances from url string
 */
interface PrintableRequestInterface extends PrinterInterface
{
    /**
     * @return RequestInterface
     */
    public function finished(): Curl\RequestInterface;
}
