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
use Jigius\Httpcli\HeadersInterface;

/**
 * Trivial implementation of Request contract
 */
final class Request implements RequestInterface
{
    /**
     * @var Httpcli\ResponseInterface
     */
    private Httpcli\ResponseInterface $resp;
    /**
     * @var array
     */
    private array $i;
    
    /**
     * Cntr
     * @param Httpcli\ResponseInterface|null $resp
     */
    public function __construct(?Httpcli\ResponseInterface $resp = null)
    {
        $this->resp = $resp ?? new Response();
        $this->i = [
            'hdrs' => new Httpcli\Headers(),
            'uri' => new Httpcli\Uri(),
            'client' => new ClientDumb()
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function withUri(Httpcli\UriInterface $uri): self
    {
        $that = $this->blueprinted();
        $that->i['uri'] = $uri;
        return $that;
    }
    
    /**
     * @inheritdoc
     */
    public function uri(): Httpcli\UriInterface
    {
        return $this->i['uri'];
    }
    
    /**
     * @inheritDoc
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): self
    {
        $that = $this->blueprinted();
        $that->i['hdrs'] = $hdrs;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function headers(): HeadersInterface
    {
        return $this->i['hdrs'];
    }
    
    /**
     * @inheritDoc
     */
    public function withClient(ClientInterface $client): self
    {
        $that = $this->blueprinted();
        $that->i['client'] = $client;
        return $that;
    }
    
    /**
     * @inheritdoc
     */
    public function client(): ClientInterface
    {
        return $this->i['client'];
    }
    
    /**
     * @inheritDoc
     */
    public function processed(): Httpcli\ResponseInterface
    {
        $respHdrs = $this->resp->headers();
        $client =
            $this
                ->i['client']
                ->withHeaders($this->i['hdrs'])
                ->withOption(CURLOPT_RETURNTRANSFER, true)
                ->withOption(CURLOPT_HEADER, false)
                ->withOption(CURLOPT_URL, $this->i['uri']->uri())
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
        return $this->resp->withBody($output)->withHeaders($respHdrs);
    }
    
    /**
     * Clones the instance;
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self($this->resp);
        $that->i = $this->i;
        return $that;
    }
}
