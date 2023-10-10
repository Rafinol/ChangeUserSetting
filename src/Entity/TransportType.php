<?php

namespace App\Entity;

enum TransportType
{
    case Telegram;
    case Email;
    case Sms;
}
