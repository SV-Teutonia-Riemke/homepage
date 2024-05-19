<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Shlink\ShortUrlProvider;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ShortUrlExtension extends AbstractExtension
{
    public function __construct(
        private readonly ShortUrlProvider $shortUrlProvider,
    ) {
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return [
            new TwigFilter('short_url', $this->shortUrlProvider->getShortUrl(...)),
        ];
    }
}
