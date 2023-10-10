<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    private int    $id;
    private string $email;
    private string $telegram;
    private string $phone;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelegram(): string
    {
        return $this->telegram;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

}
