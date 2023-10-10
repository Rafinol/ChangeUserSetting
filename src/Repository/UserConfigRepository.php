<?php

namespace App\Repository;

interface UserConfigRepository
{
    public function setConfig(int $configId, string $value): void;
}