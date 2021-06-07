<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Response;

use Jigius\Httpcli\ResponseInterface;

/**
 * Class VanillaResponse
 * @package Jigius\Httpcli\Response
 */
final class VanillaResponse implements ResponseInterface
{
    /**
     * @var mixed
     */
    private array $i;

    /**
     * VanillaResponse constructor.
     */
    public function __construct()
    {
        $this->i = [];
    }

    /**
     * @return mixed|string
     */
    public function content()
    {
        return $this->i;
    }

    /**
     * @param mixed $input
     * @return ResponseInterface
     */
    public function with($input): ResponseInterface
    {
        $obj = new self();
        $obj->i = $input;
        return $obj;
    }
}
