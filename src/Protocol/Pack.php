<?php
/**
 * This file is part of Serendipity Job
 * @license  https://github.com/serendipitySwow/Serendipity-job/blob/main/LICENSE
 */

declare(strict_types=1);

namespace SerendipitySwow\Socket\Protocol;

class Pack
{
    /**
     *Process the sent message
     */
    public static function pack(string $data): string
    {
        return pack('n', strlen($data)) . $data;
    }

    /**
     * Get message length
     */
    public static function length(string $head): int
    {
        return unpack('n', $head)[1];
    }
}
