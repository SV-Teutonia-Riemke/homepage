<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File extends AbstractEntity implements Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Directory::class, inversedBy: 'files')]
    private ?Directory $directory;

    public function __construct(string $name, ?Directory $directory)
    {
        $this->name      = $name;
        $this->directory = $directory;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDirectory(): ?Directory
    {
        return $this->directory;
    }

    public function setDirectory(?Directory $directory): void
    {
        $this->directory = $directory;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
