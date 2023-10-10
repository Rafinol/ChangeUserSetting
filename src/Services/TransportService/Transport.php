<?php

declare(strict_types=1);

namespace App\Services\NotificationService;

interface Transport
{
    public function send(string $recipient, string $message): void;
}