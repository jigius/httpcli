<?php
/*
 * This file is part of the jigius/httpcli project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed in the root of the source code
 *
 * @copyright Copyright (c) 2022 Jigius <jigius@gmail.com>
 * @link https://github.com/jigius/httpcli GitHub
 */

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;
use RuntimeException;

/**
 * Trivial client
 */
final class Client implements ClientInterface
{
    /**
     * @var resource
     */
    private $resource;
    
    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }
    
    /**
     * @inheritdoc
     */
    public function withHeaders(Httpcli\HeadersInterface $h): self
    {
        $rqHdrs = [];
        $h->each(function (Httpcli\HeaderInterface $h) use (&$rqHdrs) {
            $rqHdrs[] = $h->name() . ": " . $h->value();
        });
        $that = $this->blueprinted();
        if (!empty($rqHdrs)) {
            $that = $that->withOption(CURLOPT_HTTPHEADER, $rqHdrs);
        }
        return $that;
    }
    
    /**
     * @inheritdoc
     * @throw RuntimeException
     */
    public function withOption(int $option, $value): ClientInterface
    {
        if (curl_setopt($this->resource, $option, $value) === false) {
            throw
                new RuntimeException(
                    "Could not configure a CURL-connection with option=`$option`",
                    0,
                    new RuntimeException(curl_error($this->resource), curl_errno($this->resource))
                );
        }
        return $this;
    }
    
    /**
     * @inheritdoc
     * @throws RuntimeException
     */
    public function withCopiedConnection(): self
    {
        $that = $this->blueprinted();
        if (($that->resource = curl_copy_handle($this->resource)) === false) {
            throw
                new RuntimeException(
                    "Could not duplicate a resource",
                    0,
                    new RuntimeException(curl_error($this->resource), curl_errno($this->resource))
                );
        }
        return $that;
    }
    
    /**
     * @inheritdoc
     * @throws RuntimeException
     */
    public function execute()
    {
        $output = curl_exec($this->resource);
        if (curl_errno($this->resource) !== 0) {
            throw
                new RuntimeException(
                    "an error has been occurred in time of the data fetching",
                    0,
                    new RuntimeException(curl_error($this->resource), curl_errno($this->resource))
                );
        }
        return $output;
    }
    
    /**
     * @inheritdoc
     * @throws RuntimeException
     */
    public function close(): void
    {
        if (curl_close($this->resource) === false) {
            throw
                new RuntimeException(
                    "Could not close a resource",
                    0,
                    new RuntimeException(curl_error($this->resource), curl_errno($this->resource))
                );
        }
    }
    
    /**
     * @inheritdoc
     */
    public function resource()
    {
        return $this->resource;
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        return new self($this->resource);
    }
}
