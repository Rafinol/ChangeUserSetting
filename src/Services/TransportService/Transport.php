<?php

declare(strict_types=1);

namespace App\Services\NotificationService;

interface Notification
{
    public function send(string $recipient, string $message): void;
}