<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Request\Client;

use Jigius\Httpcli\Request\ClientInterface;
use RuntimeException;
use DomainException;

/**
 * Class CurlClient
 * @package Jigius\Httpcli\Request\Client
 */
final class CurlClient implements ClientInterface
{
    /**
     * @var array
     */
    private array $opts;

    /**
     * @var array
     */
    private array $hdrs;

    /**
     * @var string
     */
    private string $h;

    /**
     * @var string
     */
    private string $uri;

    /**
     * @var array
     */
    private array $params;

    /**
     * Curl constructor.
     * @param array $headers
     * @param array $options
     */
    public function __construct(array $headers = [], array $options = [])
    {
        $this->hdrs = $headers;
        $this->opts = $options;
        $this->params = [];
        $this->h = "";
        $this->uri = "";
    }

    /**
     * Clones current instance
     * @return $this
     */
    private function blueprinted(): self
    {
        $obj = new self($this->hdrs, $this->opts);
        $obj->h = $this->h;
        $obj->uri = $this->uri;
        $obj->params = $this->params;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function withHeader(string $header): ClientInterface
    {
        $obj = $this->blueprinted();
        $obj->hdrs[] = $header;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function withOption(string $name, $val): ClientInterface
    {
        $obj = $this->blueprinted();
        $obj->opts[$name] = $val;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function withUriParam(string $name, $val): ClientInterface
    {
        $obj = $this->blueprinted();
        $obj->params[$name] = $val;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function withUri(string $uri): ClientInterface
    {
        $obj = $this->blueprinted();
        $obj->uri = $uri;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function withHostname(string $hostname): ClientInterface
    {
        $obj = $this->blueprinted();
        $obj->h = $hostname;
        return $obj;
    }

    /**
     * @inheritDoc
     */
    public function execute(): string
    {
        if (empty($this->h)) {
            throw new DomainException("there is no `hostname` specified");
        }
        if (($ch = curl_init()) === false) {
            throw
                new RuntimeException(
                    "client initialization is failure: curl_init() returned `false`",
                );
        }
        array_walk(
            $this->opts,
            function ($val, $name) use ($ch) {
                curl_setopt($ch, $name, $val);
            }
        );
        if (!empty($this->hdrs)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->hdrs);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $this->url());
        }
        if (($output = curl_exec($ch)) === false) {
            throw
                new RuntimeException(
                    curl_error($ch),
                    curl_errno($ch)
                );
        }
        curl_close($ch);
        return $output;
    }

    /**
     * Constructs url from parts
     * @return string
     */
    private function url(): string
    {
        return
            implode(
                "",
                [
                    $this->h,
                    $this->uri,
                    strpos($this->uri, "?") >=0? "&": "?",
                    http_build_query($this->params)
                ]
            );
    }
}
