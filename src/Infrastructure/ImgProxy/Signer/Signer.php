<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

interface Signer
{
    public function sign(string $string): string;
}
