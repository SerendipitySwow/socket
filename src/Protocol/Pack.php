<?php
declare(strict_types=1);

namespace SerendipitySwow\Socket\Protocol;

class Pack
{
    /**
     *Process the sent message
     *
     * @param string $data
     *
     * @return string
     */
    public static function pack(string $data): string
    {
        return pack('n', strlen($data)) . $data;
    }

    /**
     * Get message length
     *
     * @param string $head
     *
     * @return int
     */
    public static function length(string $head): int
    {
        return unpack('n', $head)[1];
    }
}
