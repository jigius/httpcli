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

/**
 * Trivial implementation of Request contract
 */
final class Request implements RequestInterface
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $resp;
    /**
     * @var Httpcli\HeadersInterface
     */
    private Httpcli\HeadersInterface $hdrs;
    /**
     * @var Httpcli\UriInterface
     */
    private Httpcli\UriInterface $uri;
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;
    
    /**
     * Cntr
     * @param ResponseInterface|null $resp
     */
    public function __construct(?ResponseInterface $resp = null)
    {
        $this->resp = $resp ?? new Response();
        $this->hdrs = new Httpcli\Headers();
        $this->uri = new Httpcli\Uri();
        $this->client = new ClientDumb();
    }
    
    /**
     * @inheritDoc
     */
    public function withUri(Httpcli\UriInterface $uri): self
    {
        $that = $this->blueprinted();
        $that->uri = $uri;
        return $that;
    }
    
    /**
     * @inheritdoc
     */
    public function uri(): Httpcli\UriInterface
    {
        return $this->uri;
    }
    
    /**
     * @inheritDoc
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): self
    {
        $that = $this->blueprinted();
        $that->hdrs = $hdrs;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withClient(ClientInterface $client): self
    {
        $that = $this->blueprinted();
        $that->client = $client;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function processed(): ResponseInterface
    {
        $respHdrs = $this->resp->headers();
        $client =
            $this
                ->client
                ->withHeaders($this->hdrs)
                ->withOption(CURLOPT_RETURNTRANSFER, true)
                ->withOption(CURLOPT_HEADER, false)
                ->withOption(CURLOPT_URL, $this->uri->uri())
                ->withOption(
                    CURLOPT_HEADERFUNCTION,
                    (function (Httpcli\HeadersInterface &$hdrs, Httpcli\HeaderInterface $h): callable {
                        return
                            function($ch, $header) use ($h, &$hdrs) {
                                $len = strlen($header);
                                $header = explode(':', $header, 2);
                                if (count($header) < 2) {
                                    /* ignoring invalid headers */
                                    return $len;
                                }
                                $hdrs =
                                    $hdrs
                                        ->pushed(
                                            $h
                                                ->withName(
                                                    trim($header[0])
                                                )
                                                ->withValue(
                                                    trim($header[1])
                                                )
                                        );
                                return $len;
                            };
                    }) ($respHdrs, new Httpcli\Header())
                );
        $output = $client->execute();
        return
            $this
                ->resp
                ->withBody($output)
                ->withHeaders($respHdrs)
                ->withClient($this->client);
    }
    
    /**
     * Clones the instance;
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self($this->resp);
        $that->uri = $this->uri;
        $that->hdrs = $this->hdrs;
        $that->client = $this->client;
        return $that;
    }
}
