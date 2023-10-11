<?php

declare(strict_types=1);

namespace App\UseCase\UserSetting;

class ConfirmDto
{
    public string $code;

    /** @psalm-suppress UnusedMethod */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
