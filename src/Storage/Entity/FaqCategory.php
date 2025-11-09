<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\Enabled;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Repository\FaqCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\AbstractString;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: FaqCategoryRepository::class)]
class FaqCategory extends AbstractEntity implements EnabledInterface, PositionInterface
{
    use Enabled;
    use Position;

    /** @var Collection<array-key, FaqArticle> */
    #[ORM\OneToMany(targetEntity: FaqArticle::class, mappedBy: 'group')]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $articles;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $title,
    ) {
        $this->articles = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /** @return Collection<array-key, FaqArticle> */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function getSlug(SluggerInterface $slugger): AbstractString
    {
        return $slugger->slug($this->getTitle());
    }
}
