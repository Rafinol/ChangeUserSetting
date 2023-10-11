<?php

declare(strict_types=1);

namespace App\UseCase\UserSetting;

use App\Entity\TransportType;
use App\Services\TransportService\Email;
use App\Services\TransportService\Sms;
use App\Services\TransportService\Telegram;
use App\Services\TransportService\Transport;

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
