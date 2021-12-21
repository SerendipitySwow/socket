<?php
/**
 * This file is part of Serendipity Job
 * @license  https://github.com/swow-cloud/socket/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SwowCloud\Socket\Interfaces;

use SwowCloud\Socket\Exceptions\OpenStreamException;
use SwowCloud\Socket\Exceptions\StreamStateException;
use SwowCloud\Socket\Exceptions\WriteStreamException;

interface StreamInterface
{
    /**
     * Has the stream already been opened?
     */
    public function isOpen(): bool;

    /**
     * Opens a stream
     *
     * @throws OpenStreamException
     * @throws StreamStateException
     */
    public function open(): void;

    /**
     * Closes a stream
     */
    public function close(): void;

    /**
     * Writes the contents of the string to the stream.
     *
     * @param string $string the string that is to be written
     *
     * @throws StreamStateException
     * @throws WriteStreamException
     */
    public function write(string $string): void;

    /**
     * Read a single character from the stream.
     *
     * @param int $length read length
     *
     * @throws StreamStateException
     * @return null|string Returns a string containing a single character read
     *                     from the stream. Returns NULL on EOF.
     */
    public function readChar(int $length = 65535): ?string;
}
