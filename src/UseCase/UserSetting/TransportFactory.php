<?php

declare(strict_types=1);

namespace App\UseCase\UserSetting;

use App\Entity\TransportType;
use App\Service\TransportService\Email;
use App\Service\TransportService\Sms;
use App\Service\TransportService\Telegram;
use App\Service\TransportService\Transport;

/** @psalm-suppress UnusedClass */
class TransportFactory
{
    public function run(TransportType $transportType): Transport
    {
        return match ($transportType) {
            TransportType::Email => new Email(),
            TransportType::Telegram => new Telegram(),
            TransportType::Sms => new Sms()
        };
    }
}
