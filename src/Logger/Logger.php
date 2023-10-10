<?php

namespace App\Logger;

class Logger
{
    private const LOG_FILE_NAME = '../../public/logs/log';

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
}