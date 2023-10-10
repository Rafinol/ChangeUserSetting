<?php

declare(strict_types=1);

use App\Logger\Logger;
use App\Services\NotificationService\Notification;

class Email implements Notification
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Notification by Email. Message to ' . $recipient . '. Context: ' . $message);
    }
}