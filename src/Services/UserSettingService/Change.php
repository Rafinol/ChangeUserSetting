<?php

namespace App\Services\UserSettingService;

interface Change
{
    public function apply(int $configId, string $configValue): void;
}
