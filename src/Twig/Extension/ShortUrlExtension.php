<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Shlink\ShortUrlProvider;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ShortUrlExtension extends AbstractExtension
{
    public function __construct(
        private readonly ShortUrlProvider $shortUrlProvider,
        private readonly ShlinkClient|null $shlinkClient,
    ) {
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return [
            new TwigFilter('short_url', $this->shortUrlProvider->getShortUrl(...)),
        ];
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('short_url_enabled', fn (): bool => $this->shlinkClient !== null),
        ];
    }
}
