<?php

namespace App\UseCase\UserSetting;

use App\Entity\User;
use ConfirmationService\Confirmation;

class ChangeUserSetting
{
    public function __construct(
        private Confirmation $confirmation,
        private
    ){
    }

    public function change(int $settingId, string $settingValue): void
    {
    }
}