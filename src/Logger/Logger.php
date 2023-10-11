<?php

declare(strict_types=1);

namespace App\Logger;

use SplFileObject;

class Logger
{
    private const LOG_FILE_NAME = __DIR__ . '/../../public/logs/log';

    public static function info($message): void
    {
        if (!file_exists(self::LOG_FILE_NAME)) {
            $file = fopen(self::LOG_FILE_NAME, 'wb');
            fclose($file);
        }

        $file = fopen(self::LOG_FILE_NAME, 'ab');
        fwrite($file, $message . PHP_EOL);
        fclose($file);
    }

    /** @psalm-suppress UnusedMethod */
    public static function getLastMessages(int $count = 1): array
    {
        $file = new SplFileObject(self::LOG_FILE_NAME);

        $lines = [];

        while (!$file->eof()) {
            $file->next();
            $lines[] = $file->current();
        }

        return array_slice(array_reverse($lines), 1, $count);
    }
}
