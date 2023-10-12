<?php

declare(strict_types=1);

namespace App\Service\TransportService;

interface Transport
{
    public function send(string $recipient, string $message): void;
}
