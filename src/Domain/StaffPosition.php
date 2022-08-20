<?php

declare(strict_types=1);

namespace App\Domain;

enum StaffPosition: string
{
    case TRAINER    = 'trainer';
    case CO_TRAINER = 'co_trainer';
}
