<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Uid\Uuid;

use function sprintf;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File extends AbstractEntity implements Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private string $safeName;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $extension;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $mimeType;

    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(type: Types::STRING, unique: true)]
    private string $filePath;

    #[ORM\ManyToOne(targetEntity: Directory::class, inversedBy: 'files')]
    private ?Directory $directory;

    public function __construct(
        string $name,
        string $safeName,
        ?string $extension,
        ?string $mimeType,
        Uuid $uuid,
        string $filePath,
        ?Directory $directory
    ) {
        $this->name      = $name;
        $this->safeName  = $safeName;
        $this->extension = $extension;
        $this->mimeType  = $mimeType;
        $this->uuid      = $uuid;
        $this->filePath  = $filePath;
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

    public function getFileName(): string
    {
        return sprintf('%s.%s', $this->safeName, $this->extension);
    }

    public function getSafeName(): string
    {
        return $this->safeName;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
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
        return $this->getFileName();
    }
}
