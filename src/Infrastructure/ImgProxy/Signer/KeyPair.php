<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Signer;

use App\Infrastructure\ImgProxy\Helper\Encoder;

use function hash_hmac;
use function pack;

final readonly class KeyPair implements Signer
{
    private string $key;

    private string $salt;

    public function __construct(
        string $key,
        string $salt,
    ) {
        $this->key  = pack('H*', $key);
        $this->salt = pack('H*', $salt);
    }

    public function __invoke(string $string): string
    {
        return Encoder::encode(hash_hmac('sha256', $this->salt . $string, $this->key, true));
    }
}
