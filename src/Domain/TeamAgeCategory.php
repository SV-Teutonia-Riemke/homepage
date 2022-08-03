<?php

declare(strict_types=1);

namespace App\Domain;

enum TeamAgeCategory: string
{
    case JUNIOR = 'junior';
    case SENIOR = 'senior';
}
