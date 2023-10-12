<?php

namespace App\Service\UserSettingService;

interface Change
{
    public function apply(int $configId, string $configValue): void;
}
