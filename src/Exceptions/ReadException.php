<?php
/**
 * This file is part of Serendipity Job
 * @license  https://github.com/swow-cloud/socket/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Socket\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class ReadException extends RuntimeException
{
    private string $response;

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @see https://php.net/manual/en/exception.construct.php
     *
     * @param string $response [optional] The response from the serial port until the exception is thrown
     * @param string $message [optional] The Exception message to throw
     * @param int $code [optional] The Exception code
     * @param null|\Throwable $previous [optional] The previous throwable used for the
     *                                  exception chaining
     */
    #[Pure]
    public function __construct(
        string $response = '',
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): string
    {
        return $this->response;
    }
}
