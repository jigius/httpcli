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
use InvalidArgumentException;

/**
 * Class Response
 * @package Jigius\Httpcli
 */
final class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private array $i;
    
    /**
     * Cntr
     */
    public function __construct()
    {
        $this->i = [
            'hdrs' => new Httpcli\Headers(),
            'client' => new ClientDumb(),
            'body' => null
        ];
    }
    
    /**
     * @inheritDoc
     * @throws InvalidArgumentException
     */
    public function body(): string
    {
        return $this->i['body'];
    }
    
    /**
     * @inheritDoc
     */
    public function withBody(string &$streamOfBytes): self
    {
        $that = $this->blueprinted();
        $that->i['body'] = &$streamOfBytes;
        return $that;
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
     * @throws InvalidArgumentException
     */
    public function client(): ClientInterface
    {
        return $this->i['client'];
    }
    
    /**
     * @inheritDoc
     */
    public function headers(): Httpcli\HeadersInterface
    {
        return $this->i['hdrs'];
    }
    
    /**
     * Clones the instance
     * @return $this
     */
    public function blueprinted(): self
    {
        $that = new self();
        $that->i = $this->i;
        return $that;
    }
}
