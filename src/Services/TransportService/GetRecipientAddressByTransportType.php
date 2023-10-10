<?php

declare(strict_types=1);

namespace App\Services\TransportService;

use App\Entity\User;
use App\Exception\NotFoundTransportException;

class GetRecipientAddressByTransportType
{
    /**
     * @throws NotFoundTransportException
     */
    public function getAddress(Transport $transport, User $user): string
    {
        return match ($transport::class) {
            Sms::class => $user->getPhone(),
            Telegram::class => $user->getTelegram(),
            Email::class => $user->getEmail(),
            default => throw new NotFoundTransportException(),
        };
    }
}