<?php

namespace App\Services\CodeGeneratorService;

interface CodeGenerator
{
    public function generate(): string;
}