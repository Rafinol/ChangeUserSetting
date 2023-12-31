<?php

declare(strict_types=1);

namespace App\Service\UserSettingService;

use App\Repository\UserConfigRepository;

/** @psalm-suppress UnusedClass */
readonly class ChangeService implements Change
{
    public function __construct(private UserConfigRepository $userConfigRepository)
    {
    }

    public function apply(int $configId, string $configValue): void
    {
        $this->userConfigRepository->setConfig($configId, $configValue);
    }
}
