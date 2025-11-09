<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\FileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

use function implode;
use function sprintf;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File extends AbstractEntity implements Stringable
{
    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
        #[ORM\Column(type: Types::STRING)]
        private string $safeName,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $extension,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $mimeType,
        #[ORM\Column(type: UuidType::NAME, unique: true)]
        private Uuid $uuid,
        #[ORM\Column(type: Types::STRING, unique: true)]
        private string $filePath,
        #[ORM\ManyToOne(targetEntity: Directory::class, inversedBy: 'files')]
        private Directory|null $directory,
    ) {
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

    public function setSafeName(string $safeName): void
    {
        $this->safeName = $safeName;
    }

    public function getExtension(): string|null
    {
        return $this->extension;
    }

    public function getMimeType(): string|null
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

    public function getDirectory(): Directory|null
    {
        return $this->directory;
    }

    public function setDirectory(Directory|null $directory): void
    {
        $this->directory = $directory;
    }

    public function getPathName(string $separator = ' / '): string
    {
        return implode($separator, $this->getPathArray());
    }

    /** @return list<string> */
    public function getPathArray(): array
    {
        $names   = $this->directory === null ? [] : $this->directory->getPathArray();
        $names[] = $this->getFileName();

        return $names;
    }

    public function __toString(): string
    {
        return $this->getFileName();
    }
}
