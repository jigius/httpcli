<?php

namespace Jigius\Httpcli\Curl\ParsedUrl;

use Jigius\Httpcli\Curl;

/**
 * Does a transformation of a passed URL as string to the Request instance
 */
final class Request implements ParsableUrlInterface
{
    /**
     * @var Curl\RequestInterface
     */
    private Curl\RequestInterface $req;
    
    /**
     * Cntr
     * @param Curl\RequestInterface $req
     */
    public function __construct(Curl\RequestInterface $req)
    {
        $this->req = $req;
    }
    
    /**
     * @inheritDoc
     */
    public function request(string $url): Curl\RequestInterface
    {
        $req = $this->req;
        $i = parse_url($url);
        if (isset($i['scheme'])) {
            $req = $req->withScheme($i['scheme']);
        }
        if (isset($i['host'])) {
            $req = $req->withHostName($i['host']);
        }
        if (isset($i['port'])) {
            $req = $req->withPort($i['port']);
        }
        if (isset($i['user'])) {
            $req = $req->withLogin($i['user']);
        }
        if (isset($i['pass'])) {
            $req = $req->withPassword($i['pass']);
        }
        if (isset($i['path'])) {
            $req = $req->withPath($i['path']);
        }
        if (isset($i['query'])) {
            $req = $req->withParams(explode("&", $i['query']));
        }
        return $req;
    }
}
