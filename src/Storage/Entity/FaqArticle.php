<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\Enabled;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Repository\FaqArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: FaqArticleRepository::class)]
class FaqArticle extends AbstractEntity implements EnabledInterface, PositionInterface
{
    use Enabled;
    use Position;

    #[Gedmo\SortableGroup]
    #[ORM\ManyToOne(targetEntity: FaqCategory::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private FaqCategory $group;

    #[ORM\Column(type: Types::STRING)]
    private string $title;

    #[ORM\Column(type: Types::TEXT)]
    private string $content;

    public function __construct(
        FaqCategory $group,
        string $title,
        string $content,
    ) {
        $this->group   = $group;
        $this->title   = $title;
        $this->content = $content;
    }

    public function getGroup(): FaqCategory
    {
        return $this->group;
    }

    public function setGroup(FaqCategory $group): void
    {
        $this->group = $group;
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
}
