<?php

namespace App\Service\CodeGeneratorService;

interface CodeGenerator
{
    public function generate(): string;
}
