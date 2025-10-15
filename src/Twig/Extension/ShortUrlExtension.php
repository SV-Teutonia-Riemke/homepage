<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Shlink\ShortUrlProvider;
use Twig\Attribute\AsTwigFilter;
use Twig\Attribute\AsTwigFunction;

final readonly class ShortUrlExtension
{
    public function __construct(
        private ShortUrlProvider $shortUrlProvider,
    ) {
    }

    /** @param array<string> $tags */
    #[AsTwigFilter('short_url')]
    public function getShortUrl(
        string $url,
        array $tags = [],
    ): string {
        return $this->shortUrlProvider->getShortUrl($url, $tags);
    }

    #[AsTwigFunction('short_url_enabled')]
    public function isShortUrlEnabled(): bool
    {
        return $this->shortUrlProvider->isShlinkEnabled();
    }
}
