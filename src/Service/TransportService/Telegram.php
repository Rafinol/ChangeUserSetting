<?php

declare(strict_types=1);

namespace App\Service\TransportService;

use App\Logger\Logger;

class Telegram implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Telegram for ' . $recipient . '. ' . $message);
    }
}
