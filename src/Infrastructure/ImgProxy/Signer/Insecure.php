<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

final readonly class Insecure implements Signer
{
    public function __invoke(string $string): string
    {
        return 'insecure';
    }
}
