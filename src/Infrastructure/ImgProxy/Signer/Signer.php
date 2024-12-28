<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

interface Signer
{
    public function __invoke(string $string): string;
}
