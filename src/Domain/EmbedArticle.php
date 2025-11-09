<?php

declare(strict_types=1);

namespace App\Domain;

use DateTime;
use Embed\Extractor;
use Psr\Http\Message\UriInterface;
use RuntimeException;

class EmbedArticle
{
    public function __construct(
        private readonly Extractor $extractor,
    ) {
    }

    public function getTitle(): string
    {
        if ($this->extractor->title === null) {
            throw new RuntimeException('Title is missing');
        }

        return $this->extractor->title;
    }

    public function getDescription(): string|null
    {
        return $this->extractor->description;
    }

    public function getUrl(): UriInterface
    {
        return $this->extractor->url;
    }

    public function getImage(): UriInterface|null
    {
        return $this->extractor->image;
    }

    public function getAuthor(): string|null
    {
        return $this->extractor->authorName;
    }

    public function getAuthorUrl(): UriInterface|null
    {
        return $this->extractor->authorUrl;
    }

    public function getPublishedTime(): DateTime|null
    {
        return $this->extractor->publishedTime;
    }
}
