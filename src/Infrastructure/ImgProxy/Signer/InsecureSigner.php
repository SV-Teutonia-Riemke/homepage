<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

class InsecureSigner implements Signer
{
    public function sign(string $string): string
    {
        return 'insecure';
    }
}
