<?php

namespace ConfirmationService;

interface Confirmation
{
    public function request(): void;

    public function confirm(): void;
}