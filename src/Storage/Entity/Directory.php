<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\DirectoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

use function array_reverse;
use function implode;

#[ORM\Entity(repositoryClass: DirectoryRepository::class)]
class Directory extends AbstractEntity implements Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private ?self $parent;

    /** @var Collection<self> */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $children;

    /** @var Collection<File> */
    #[ORM\OneToMany(mappedBy: 'directory', targetEntity: File::class)]
    private Collection $files;

    public function __construct(string $name, ?Directory $parent)
    {
        $this->name     = $name;
        $this->parent   = $parent;
        $this->children = new ArrayCollection();
        $this->files    = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getParent(): ?Directory
    {
        return $this->parent;
    }

    public function setParent(?Directory $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return Collection<self>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /**
     * @return Collection<File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function getPathName(string $separator = ' / '): string
    {
        return implode($separator, $this->getPathArray());
    }

    /**
     * @return list<string>
     */
    public function getPathArray(): array
    {
        $names = [];

        $parent = $this->getParent();
        while ($parent !== null) {
            $names[] = $parent->getName();

            $parent = $parent->getParent();
        }

        $names   = array_reverse($names);
        $names[] = $this->getName();

        return $names;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
