<?php

namespace App\UseCase\UserSetting;

use App\Entity\Config;
use App\Entity\User;
use App\Services\ConfirmationService\Confirmation;

readonly class ChangeUserConfigByCode
{
    public function __construct(
        private Confirmation $confirmation
    ) {
    }

    public function request(User $user, Config $config): void
    {
        $this->confirmation->request($user, $config);
    }

    public function confirm(User $user, Config $config, ConfirmDto $dto): void
    {
        $this->confirmation->confirm($user, $config, (array)$dto);
    }
}
