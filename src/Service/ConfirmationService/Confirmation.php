<?php

declare(strict_types=1);

namespace App\Service\ConfirmationService;

use App\Entity\Config;
use App\Entity\User;

interface Confirmation
{
    public function request(User $user, Config $config): void;

    public function confirm(User $user, Config $config, array $extraData): void;
}
