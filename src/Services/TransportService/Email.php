<?php

declare(strict_types=1);

namespace App\Services\TransportService;

use App\Logger\Logger;

class Email implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Email. Message to ' . $recipient . '. Context: ' . $message);
    }
}