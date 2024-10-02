<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\Enabled;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Repository\ArticleRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article extends AbstractEntity implements EnabledInterface
{
    use Enabled;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    #[ORM\OneToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private Person|null $author = null;

    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: true)]
    protected DateTimeInterface|null $publishedAt = null;

    public function __construct(
        string $title,
        string $content,
    ) {
        $this->title   = $title;
        $this->content = $content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImage(): File|null
    {
        return $this->image;
    }

    public function setImage(File|null $image): void
    {
        $this->image = $image;
    }

    public function getAuthor(): Person|null
    {
        return $this->author;
    }

    public function setAuthor(Person|null $author): void
    {
        $this->author = $author;
    }

    public function getPublishedAt(): DateTimeInterface|null
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTimeInterface|null $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public function getReleaseDate(): DateTimeInterface
    {
        return $this->getPublishedAt() ?? $this->getCreatedAt();
    }
}
