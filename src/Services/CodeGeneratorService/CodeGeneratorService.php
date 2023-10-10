<?php

declare(strict_types=1);

namespace App\Services\CodeGeneratorService;

class CodeGeneratorService
{
    public function generate(int $length = 4): string
    {
        return substr(md5(time() . 'some_salt'), 0, $length);
    }
}