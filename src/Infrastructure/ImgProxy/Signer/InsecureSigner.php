<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

final readonly class InsecureSigner implements Signer
{
    public function __invoke(string $string): string
    {
        return 'insecure';
    }
}
