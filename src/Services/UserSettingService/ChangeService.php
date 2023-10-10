<?php

declare(strict_types=1);


namespace App\Services\UserSettingService;

use App\Repository\UserConfigRepository;

readonly class ChangeService implements Change
{
    public function __construct(private UserConfigRepository $userSettingRepository)
    {
    }

    public function apply(int $configId, string $configValue): void
    {
        $this->userSettingRepository->setConfig($configId, $configValue);
    }
}