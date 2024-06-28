<?php

declare(strict_types=1);

namespace App\Module\Admin\Misc\Shlink;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Attribute\Exclude;
use Symfony\Component\String\AbstractString;
use Symfony\Component\String\UnicodeString;

use function count;
use function implode;

#[Exclude]
class ShortUrl
{
    public function __construct(
        public string $longUrl,
        public string|null $shortCode,
        public string|null $tags,
    ) {
    }

    public static function fromShlink(\Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrl $shortUrl): self
    {
        return new self(
            $shortUrl->longUrl,
            $shortUrl->shortCode,
            implode(', ', $shortUrl->tags),
        );
    }

    public function containsTags(): bool
    {
        return count($this->getTagsAsArray()) > 0;
    }

    /** @return array<string> */
    public function getTagsAsArray(): array
    {
        if ($this->tags === null) {
            return [];
        }

        return (new ArrayCollection((new UnicodeString($this->tags))->split(',')))
            ->map(static fn (AbstractString $tag): AbstractString => $tag->replace(',', '')->trim())
            ->filter(static fn (AbstractString $tag): bool => ! $tag->isEmpty())
            ->map(static fn (AbstractString $tag): string => $tag->toString())
            ->toArray();
    }
}
