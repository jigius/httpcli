<?php

namespace Jigius\Httpcli\Curl;

use InvalidArgumentException;
use RuntimeException;

/**
 *
 */
final class Request implements RequestInterface
{
    /**
     * @var array
     */
    private array $i;
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $resp;
    
    /**
     * Cntr
     */
    public function __construct(ResponseInterface $r)
    {
        $this->resp = $r;
        $this->i = [
            'headers' => [],
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
    public function withHeaders(array $hdrs): self
    {
        $that = $this->blueprinted();
        $that->i['headers'] = array_merge($that->i['headers'], $hdrs);
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
    public function withCurlHdlr($handler): self
    {
        $that = $this->blueprinted();
        $that->i['curlHandler'] = $handler;
        return $that;
    }
    
    /**
     * @inheritDoc
     */
    public function processed(): ResponseInterface
    {
        if (!isset($this->i['curlHandler'])) {
            throw new InvalidArgumentException("`curlHandler` is not defined");
        }
        if (!is_resource($this->i['curlHandler'])) {
            throw new InvalidArgumentException("`curlHandler` value has an invalid type");
        }
        $ch = $this->i['curlHandler'];
        if (!empty($this->hdrs)) {
            $this->curlSetOpt($ch, CURLOPT_HTTPHEADER, $this->hdrs);
            $this->curlSetOpt($ch, CURLOPT_HEADER, true);
            $this->curlSetOpt($ch, CURLOPT_RETURNTRANSFER, true);
        }
        $this->curlSetOpt($ch, CURLOPT_URL, $this->url());
        $hdrsResp = [];
        $this->curlSetOpt($ch, CURLOPT_HEADERFUNCTION,
            function($curl, $header) use (&$hdrsResp) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) {
                    /* ignoring invalid headers */
                    return $len;
                }
                $headers[strtolower(trim($header[0]))][] = trim($header[1]);
                return $len;
            }
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
                ->withContent($output)
                ->withHeaders($hdrsResp)
                ->withCode(
                    curl_getinfo($ch, CURLINFO_HTTP_CODE)
                );
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
