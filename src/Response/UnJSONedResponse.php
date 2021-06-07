<?php
declare(strict_types=1);

namespace Jigius\Httpcli\Response;

use Jigius\Httpcli\ResponseInterface;
use DomainException;

/**
 * Class UnJSONedResponse
 * @package Jigius\Httpcli\Response
 */
final class UnJSONedResponse implements ResponseInterface
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $orig;

    /**
     * UnJSONedResponse constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->orig = $response;
    }

    /**
     * @return array
     */
    public function content(): array
    {
        $input = $this->orig->content();
        $this->validate($input);
        $resp =
            json_decode(
                $this->orig->content(),
                true
            );
        if (($err = json_last_error()) !== JSON_ERROR_NONE) {
            $resp = [
                'errorCode' => -100,
                'errorMessage' => "response has invalid content's type",
                'content' => $input
            ];
            /*throw
                new RuntimeException(
                    "couldn't unJSONed response data",
                    0,
                    new RuntimeException(json_last_error_msg(), $err)
                );*/
        }
        return $resp;
    }

    /**
     * @param mixed $input
     * @return ResponseInterface
     */
    public function with($input): ResponseInterface
    {
        return
            new self(
                $this->orig->with($input)
            );
    }

    /**
     * @param $input
     */
    private function validate($input): void
    {
        if ($input === null || !is_string($input)) {
            throw new DomainException("invalid data");
        }
    }
}
