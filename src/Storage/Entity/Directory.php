<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\DirectoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

use function array_map;
use function array_reverse;
use function implode;

#[ORM\Entity(repositoryClass: DirectoryRepository::class)]
class Directory extends AbstractEntity implements Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    private self|null $parent;

    /** @var Collection<array-key, self> */
    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $children;

    /** @var Collection<array-key, File> */
    #[ORM\OneToMany(mappedBy: 'directory', targetEntity: File::class)]
    private Collection $files;

    public function __construct(
        string $name,
        Directory|null $parent,
    ) {
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

    public function getParent(): Directory|null
    {
        return $this->parent;
    }

    public function setParent(Directory|null $parent): void
    {
        $this->parent = $parent;
    }

    /** @return Collection<array-key, self> */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    /** @return Collection<array-key, File> */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    /** @return Collection<array-key, File> */
    public function getDeepFiles(): Collection
    {
        $files = new ArrayCollection($this->files->toArray());

        foreach ($this->children as $child) {
            $files = new ArrayCollection([...$files, ...$child->getDeepFiles()]);
        }

        return $files;
    }

    public function getPathName(string $separator = ' / '): string
    {
        return implode($separator, $this->getPathArray());
    }

    /** @return list<string> */
    public function getPathArray(): array
    {
        $parents = $this->getParents();
        $names   = array_map(
            static fn (self $directory) => $directory->getName(),
            $parents,
        );

        return array_reverse($names);
    }

    /** @return list<self> */
    public function getParents(): array
    {
        $parents = [$this];

        $parent = $this->getParent();
        while ($parent !== null) {
            $parents[] = $parent;

            $parent = $parent->getParent();
        }

        return $parents;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
