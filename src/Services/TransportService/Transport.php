<?php

declare(strict_types=1);

namespace App\Services\TransportService;

interface Transport
{
    public function send(string $recipient, string $message): void;
}