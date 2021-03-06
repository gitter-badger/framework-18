<?php
namespace Viserio\Http;

use InvalidArgumentException;
use Narrowspark\HttpStatus\HttpStatus;
use Psr\Http\Message\{
    ResponseInterface,
    StreamInterface
};

class Response extends AbstractMessage implements ResponseInterface
{
    /**
     * @var null|string
     */
    private $reasonPhrase = '';

    /**
     * @var int
     */
    private $statusCode = 200;

    /**
     * @param int                             $status  Status code for the response, if any.
     * @param array                           $headers Headers for the response, if any.
     * @param string|resource|StreamInterface $body    Stream identifier and/or actual stream resource
     * @param string                          $version Protocol version.

     * @throws InvalidArgumentException on any invalid element.
     */
    public function __construct(
        int $status = 200,
        array $headers = [],
        $body = null,
        $version = '1.1'
    ) {
        $this->statusCode = HttpStatus::filterStatusCode($status);

        if ($body !== '' && $body !== null) {
            $this->stream = Util::getStream($body);
        }

        $this->setHeaders($headers);
        $this->protocol = $version;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase()
    {
        if ($this->reasonPhrase == '') {
            $this->reasonPhrase = HttpStatus::getReasonPhrase($this->statusCode);
        }

        return $this->reasonPhrase;
    }

    /**
     * {@inheritdoc}
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $new = clone $this;
        $new->statusCode = HttpStatus::filterStatusCode($code);
        $new->reasonPhrase = $reasonPhrase;

        return $new;
    }
}
