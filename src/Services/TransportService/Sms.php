<?php

declare(strict_types=1);

use App\Logger\Logger;
use App\Services\NotificationService\Notification;

class Sms implements Notification
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Sms. Message to ' . $recipient . '. Context: ' . $message);
    }
}