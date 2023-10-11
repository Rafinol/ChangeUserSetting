<?php

declare(strict_types=1);

namespace App\Services\TransportService;

use App\Logger\Logger;

class Email implements Transport
{
    public function send(string $recipient, string $message): void
    {
        Logger::info('Email for ' . $recipient . '. ' . $message);
    }
}
