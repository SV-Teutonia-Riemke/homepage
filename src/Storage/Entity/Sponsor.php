<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\SponsorLevel;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Repository\SponsorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SponsorRepository::class)]
class Sponsor extends AbstractEntity implements PositionInterface, EnabledInterface
{
    use Position;

    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $url = null;

    #[ORM\Column(type: Types::STRING, enumType: SponsorLevel::class, options: ['default' => SponsorLevel::SPONSOR])]
    private SponsorLevel $level;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $enabled = true;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUrl(): string|null
    {
        return $this->url;
    }

    public function setUrl(string|null $url): void
    {
        $this->url = $url;
    }

    public function getLevel(): SponsorLevel
    {
        return $this->level;
    }

    public function setLevel(SponsorLevel $level): void
    {
        $this->level = $level;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getImage(): File|null
    {
        return $this->image;
    }

    public function setImage(File|null $image): void
    {
        $this->image = $image;
    }
}
