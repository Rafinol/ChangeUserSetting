<?php

declare(strict_types=1);

use App\Logger\Logger;
use App\Services\NotificationService\Transport;

class Sms implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Sms. Message to ' . $recipient . '. Context: ' . $message);
    }
}