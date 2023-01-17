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
use LogicException;

/**
 * Dumb client
 */
final class ClientDumb implements ClientInterface
{
    /**
     * Cntr
     */
    public function __construct()
    {
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function withHeaders(Httpcli\HeadersInterface $h): self
    {
        throw new LogicException("the instance is a dumb :(");
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function withOption(int $option, $value): ClientInterface
    {
        throw new LogicException("the instance is a dumb :(");
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function withCopiedConnection(): self
    {
        throw new LogicException("the instance is a dumb :(");
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function execute()
    {
        throw new LogicException("the instance is a dumb :(");
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function close(): void
    {
        throw new LogicException("the instance is a dumb :(");
    }
    
    /**
     * @inheritdoc
     * @throws LogicException
     */
    public function resource()
    {
        throw new LogicException("the instance is a dumb :(");
    }
}
