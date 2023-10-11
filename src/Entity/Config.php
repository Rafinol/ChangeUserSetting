<?php

declare(strict_types=1);

namespace App\Entity;

class Config
{
    private int    $id;
    private string $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
