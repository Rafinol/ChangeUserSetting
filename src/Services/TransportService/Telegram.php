<?php

declare(strict_types=1);

use App\Logger\Logger;
use App\Services\NotificationService\Transport;

class Telegram implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Telegram. Message to ' . $recipient . '. Context: ' . $message);
    }
}