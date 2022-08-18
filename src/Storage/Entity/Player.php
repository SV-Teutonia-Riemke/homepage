<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\GamePosition;
use App\Storage\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Person $person = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Team $team = null;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?File $image = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    private ?int $number = null;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: GamePosition::class)]
    private ?GamePosition $position = null;

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): void
    {
        $this->team = $team;
    }

    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image): void
    {
        $this->image = $image;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): void
    {
        $this->number = $number;
    }

    public function getPosition(): ?GamePosition
    {
        return $this->position;
    }

    public function setPosition(?GamePosition $position): void
    {
        $this->position = $position;
    }
}
