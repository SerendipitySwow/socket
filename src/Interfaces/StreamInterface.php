<?php
declare(strict_types=1);

namespace SerendipitySwow\Socket\Interfaces;

use SerendipitySwow\Socket\Exceptions\OpenStreamException;
use SerendipitySwow\Socket\Exceptions\StreamStateException;
use SerendipitySwow\Socket\Exceptions\WriteStreamException;

interface StreamInterface
{
    /**
     * Has the stream already been opened?
     *
     * @return bool
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
     * @param string $string The string that is to be written.
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
     * @return string|null Returns a string containing a single character read
     *                     from the stream. Returns NULL on EOF.
     * @throws StreamStateException
     */
    public function readChar(int $length = 65535): ?string;
}
