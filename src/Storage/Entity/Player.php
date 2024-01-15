<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\GamePosition;
use App\Storage\Repository\PlayerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player extends AbstractEntity implements Stringable
{
    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Person|null $person = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Team|null $team = null;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['unsigned' => true])]
    private int|null $number = null;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: GamePosition::class)]
    private GamePosition|null $position = null;

    public function getPerson(): Person|null
    {
        return $this->person;
    }

    public function setPerson(Person|null $person): void
    {
        $this->person = $person;
    }

    public function getTeam(): Team|null
    {
        return $this->team;
    }

    public function setTeam(Team|null $team): void
    {
        $this->team = $team;
    }

    public function getImage(): File|null
    {
        return $this->image;
    }

    public function setImage(File|null $image): void
    {
        $this->image = $image;
    }

    public function getNumber(): int|null
    {
        return $this->number;
    }

    public function setNumber(int|null $number): void
    {
        $this->number = $number;
    }

    public function getPosition(): GamePosition|null
    {
        return $this->position;
    }

    public function setPosition(GamePosition|null $position): void
    {
        $this->position = $position;
    }

    public function __toString(): string
    {
        return $this->person?->getAnonymizedName() ?? '';
    }
}
