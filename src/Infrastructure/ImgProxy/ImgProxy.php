<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy;

use App\Infrastructure\ImgProxy\Signer\Signer;

final readonly class ImgProxy
{
    private function __construct(
        private string $baseUrl,
        private Signer $signer,
    ) {
    }

    public static function create(
        string $baseUrl,
        Signer $signer,
    ): self {
        return new self($baseUrl, $signer);
    }

    public function builder(
        string $sourceUrl,
        string|null $extension = null,
    ): UrlBuilder {
        return new UrlBuilder(
            $this->baseUrl,
            $this->signer,
            $sourceUrl,
            $extension,
        );
    }
}
