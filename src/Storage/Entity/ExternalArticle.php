<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\Enabled;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Repository\ExternalArticleRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

#[ORM\Entity(repositoryClass: ExternalArticleRepository::class)]
class ExternalArticle extends AbstractEntity implements EnabledInterface
{
    use Enabled;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $url,
        #[ORM\Column(type: Types::STRING)]
        private string $title,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $description,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $imageUrl,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $authorName,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $authorUrl,
        #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: true)]
        protected DateTimeInterface|null $publishedAt = null,
    ) {
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function getImageUrl(): string|null
    {
        return $this->imageUrl;
    }

    public function getAuthorName(): string|null
    {
        return $this->authorName;
    }

    public function getAuthorUrl(): string|null
    {
        return $this->authorUrl;
    }

    public function getPublishedAt(): DateTimeInterface|null
    {
        return $this->publishedAt;
    }
}
