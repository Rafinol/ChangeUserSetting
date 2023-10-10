<?php

declare(strict_types=1);

namespace App\Services\TransportService;

use App\Logger\Logger;

class Telegram implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Telegram. Message to ' . $recipient . '. Context: ' . $message);
    }
}