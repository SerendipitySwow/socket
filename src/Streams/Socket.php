<?php
/**
 * This file is part of Serendipity Job
 * @license  https://github.com/serendipitySwow/Serendipity-job/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SerendipitySwow\Socket\Streams;

use SerendipitySwow\Socket\Exceptions\ReadException;
use SerendipitySwow\Socket\Exceptions\StreamStateException;
use SerendipitySwow\Socket\Exceptions\WriteStreamException;
use SerendipitySwow\Socket\Interfaces\StreamInterface;
use Swow\Socket as SwowSocket;
use Throwable;

final class Socket implements StreamInterface
{
    /**
     * Default connection timeout in seconds.
     */
    public const DEFAULT_CONNECTION_TIMEOUT = 5 * 1000;

    /**
     * Default write timeout in seconds.
     */
    public const DEFAULT_WRITE_TIMEOUT = 5 * 1000;

    /**
     * Default read timeout in seconds.
     */
    public const DEFAULT_READ_TIMEOUT = -1;

    /**
     * @var string Hostname/IP
     */
    private string $host;

    /**
     * @var int TCP port
     */
    private int $port;

    /**
     * @var int Connection timeout
     */
    private int $connectionTimeout;

    /**
     * @var int Write timeout
     */
    private int $writeTimeout;

    /**
     * @var int Read timeout
     */
    private int $readTimeout;

    private ?SwowSocket $socket = null;

    public function __construct(
        string $host,
        int $port,
        int $connectionTimeout = null,
        int $writeTimeout = null,
        int $readTimeout = null
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->connectionTimeout = $connectionTimeout ?: self::DEFAULT_CONNECTION_TIMEOUT;
        $this->writeTimeout = $writeTimeout ?: self::DEFAULT_WRITE_TIMEOUT;
        $this->readTimeout = $readTimeout ?: self::DEFAULT_READ_TIMEOUT;
    }

    /**
     * Socket destructor
     */
    public function __destruct()
    {
        $this->close();
    }

    public function isOpen(): bool
    {
        return (bool) $this->socket?->isEstablished();
    }

    /**
     * @throws Throwable
     */
    public function open(): void
    {
        if ($this->isOpen()) {
            throw new StreamStateException('Stream already opened.');
        }
        $socket = new SwowSocket(SwowSocket::TYPE_TCP);
        $this->socket = $socket;
        $this->socket->connect($this->host, $this->port, $this->connectionTimeout);
        $this->writeTimeout && $this->socket->setWriteTimeout($this->writeTimeout);
        $this->readTimeout && $this->socket->setReadTimeout($this->readTimeout);
    }

    public function close(): void
    {
        if ($this->isOpen()) {
            $this->socket->close();
            $this->socket = null;
        }
    }

    public function write(string $string): void
    {
        if (!$this->isOpen()) {
            throw new StreamStateException('Stream not opened.');
        }
        try {
            $this->socket->sendString($string);
        } catch (Throwable $throwable) {
            throw new WriteStreamException(sprintf(
                'SwowSocket An error occurred while writing to the socket error:%s in:[%d] file:%s',
                $throwable->getMessage(),
                $throwable->getLine(),
                $throwable->getFile()
            ));
        }
    }

    public function readChar(int $length = null): ?string
    {
        if (!$this->isOpen()) {
            throw new StreamStateException('Stream not opened.');
        }
        try {
            $char = $this->socket->recvString($length === null ? \Swow\Buffer::DEFAULT_SIZE : $length);
            if ($char === '') {
                return null;
            }

            return $char;
        } catch (Throwable $throwable) {
            throw new ReadException(sprintf(
                'SwowSocket An error occurred while reading the socket error:%s in:[%d] file:%s ',
                $throwable->getMessage(),
                $throwable->getLine(),
                $throwable->getFile()
            ));
        }
    }
}
