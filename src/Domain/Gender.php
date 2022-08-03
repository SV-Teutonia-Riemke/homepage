<?php

declare(strict_types=1);

namespace App\Domain;

enum Gender: string
{
    case MIXED  = 'mixed';
    case MALE   = 'male';
    case FEMALE = 'female';
}
