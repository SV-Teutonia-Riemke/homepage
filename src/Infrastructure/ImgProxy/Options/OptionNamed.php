<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

interface OptionNamed extends Option
{
    public static function name(): string;
}
