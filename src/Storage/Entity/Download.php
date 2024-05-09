<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Repository\DownloadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: DownloadRepository::class)]
class Download extends AbstractEntity implements Stringable, PositionInterface, EnabledInterface
{
    use Position;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $uri;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'CASCADE')]
    private File|null $file;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $enabled = true;

    public function __construct(
        string $name,
        string|null $uri,
        File|null $file,
    ) {
        $this->name = $name;
        $this->uri  = $uri;
        $this->file = $file;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUri(): string|null
    {
        return $this->uri;
    }

    public function setUri(string|null $uri): void
    {
        $this->uri = $uri;
    }

    public function getFile(): File|null
    {
        return $this->file;
    }

    public function setFile(File|null $file): void
    {
        $this->file = $file;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
