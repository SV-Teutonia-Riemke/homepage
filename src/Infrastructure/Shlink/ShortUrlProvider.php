<?php

declare(strict_types=1);

namespace App\Infrastructure\Shlink;

use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrlCreation;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

use function implode;
use function sha1;

class ShortUrlProvider
{
    public function __construct(
        private readonly CacheInterface $cache,
        private readonly ShlinkClient $shlinkClient,
    ) {
    }

    /** @param array<string> $tags */
    public function getShortUrl(string $url, array $tags = []): string
    {
        $hashList = [$url, ...$tags];
        $hash     = sha1(implode('|', $hashList));

        return $this->cache->get($hash, function (ItemInterface $item) use ($url, $tags): string {
            $item->expiresAfter(60 * 60 * 24);

            return $this->createShortUrl($url, $tags);
        });
    }

    /** @param array<string> $tags */
    private function createShortUrl(string $url, array $tags = []): string
    {
        $creation = ShortUrlCreation::forLongUrl($url)
            ->withTags(...$tags)
            ->returnExistingMatchingShortUrl();

        return $this->shlinkClient->createShortUrl($creation)->shortUrl;
    }
}
