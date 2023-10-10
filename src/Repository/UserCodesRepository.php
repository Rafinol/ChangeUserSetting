<?php

declare(strict_types=1);


namespace App\Repository;

interface UserCodesRepository
{
    public function getCodeByUserIdByConfigId(int $userId, int $configId): ?string;

    public function setCodeForUserIdAndConfigId(int $userId, int $configId): void;
}