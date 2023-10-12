<?php

declare(strict_types=1);

namespace App\Service\TransportService;

use App\Logger\Logger;

class Sms implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Sms. Message to ' . $recipient . '. Context: ' . $message);
    }
}
