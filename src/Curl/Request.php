<?php

namespace Jigius\Httpcli\Curl;

use Jigius\Httpcli;
use Jigius\Httpcli\HeadersInterface;
use RuntimeException;
use InvalidArgumentException;

final class Request implements RequestInterface
{
    /**
     * @var array
     */
    private array $i;
    /**
     * @var ResponseInterface|null
     */
    private ?ResponseInterface $resp;
    /**
     * @var HeadersInterface
     */
    private HeadersInterface $hdrs;
    
    /**
     * Cntr
     * @param HeadersInterface|null $hdrs
     * @param ResponseInterface|null $resp
     */
    public function __construct(?Httpcli\HeadersInterface $hdrs = null, ?ResponseInterface $resp = null)
    {
        $this->resp = $resp;
        $this->hdrs = $hdrs ?? new Httpcli\Headers();
        $this->i = [
            'scheme' => "https"
        ];
    }
    
    /**
     * @inheritDoc
     */
    public function withPath(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['path'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHeaders(Httpcli\HeadersInterface $hdrs): self
    {
        $that = $this->blueprinted();
        $that->i['headers'] = $hdrs;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withScheme(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['scheme'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHostName(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['hostname'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withLogin(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['login'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withPassword(string $txt): self
    {
        $that = $this->blueprinted();
        $that->i['password'] = $txt;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withPort(int $n): self
    {
        $that = $this->blueprinted();
        $that->i['port'] = $n;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withParams(array $params): self
    {
        $that = $this->blueprinted();
        $that->i['params'] = $params;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function withHandler($curl): self
    {
        $that = $this->blueprinted();
        $that->i['curl'] = $curl;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function processed(): ResponseInterface
    {
        $resp = $resp ?? new Response();
        if (!isset($this->i['curl'])) {
            throw new InvalidArgumentException("`handler` is not defined");
        }
        if (!is_resource($this->i['curl'])) {
            throw new InvalidArgumentException("`handler` value has an invalid type");
        }
        $ch = $this->i['curl'];
        (function ($ch, Httpcli\HeadersInterface $hdrs) {
            /**
             * Appends request headers
             */
            $rqHdrs = [];
            $hdrs->each(function (Httpcli\HeaderInterface $h) use (&$rqHdrs) {
                $rqHdrs[] = $h->name() . "=" . $h->value();
            });
            if (!empty($rqHdrs)) {
                $this->curlSetOpt($ch, CURLOPT_HTTPHEADER, $rqHdrs);
            }
        }) ($ch, $this->i['headers']);
        $this->curlSetOpt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->curlSetOpt($ch, CURLOPT_HEADER, true);
        $this->curlSetOpt($ch, CURLOPT_URL, $this->url());
        $respHdrs = $this->resp->headers();
        $this->curlSetOpt(
            $ch,
            CURLOPT_HEADERFUNCTION,
            (function (Httpcli\HeadersInterface $hdrs, Httpcli\HeaderInterface $h): callable {
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
        if (($output = curl_exec($ch)) === false) {
            throw
                new RuntimeException(
                    "request was failure",
                    0,
                    new RuntimeException(
                        curl_error($ch),
                        curl_errno($ch)
                    )
                );
        }
        return
            $this
                ->resp
                ->withBody($output)
                ->withHeaders($respHdrs)
                ->withHandler($ch);
    }
    
    /**
     * Clones the instance;
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self($this->hdrs, $this->resp);
        $that->i = $this->i;
        return $that;
    }
    
    /**
     * @param $ch
     * @param int $option
     * @param $value
     * @return void
     * @throws RuntimeException
     */
    private function curlSetOpt($ch, int $option, $value): void
    {
        if (curl_setopt($ch, $option, $value) === false) {
            throw
                new RuntimeException(
                    "request's params building is failure",
                    0,
                    new RuntimeException(
                        curl_error($ch),
                        curl_errno($ch)
                    )
                );
        }
    }
    
    /**
     * Returns a constructed url from values are passed into the instance
     * @return string
     */
    private function url(): string
    {
        $res = [
            $this->i['scheme'],
            "://"
        ];
        if (isset($this->i['login'])) {
            $res[] = $this->i['login'];
            if ($this->i['password']) {
                $res[] = ":{$this->i['password']}";
            }
            $res[] = "@";
        }
        if (isset($this->i['hostname'])) {
            $res[] = $this->i['hostname'];
        }
        if (isset($this->i['port'])) {
            $res[] = ":{$this->i['port']}";
        }
        if (isset($this->i['path'])) {
            $res[] = urlencode($this->i['path']);
        }
        if (!empty($this->i['params'])) {
            $res[] = "?";
            $res[] =
                implode(
                    "&",
                    array_map(
                        function ($key, $value): string {
                            return urlencode($key) . "=" .urlencode($value);
                        },
                        $this->i['params']
                    )
                );
        }
        return implode("", $res);
    }
}
