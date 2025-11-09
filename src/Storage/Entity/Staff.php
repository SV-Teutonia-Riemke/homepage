<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\StaffPosition;
use App\Storage\Repository\StaffRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
class Staff extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Person|null $person = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'staffs')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Team|null $team = null;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: StaffPosition::class)]
    private StaffPosition|null $position = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $emailAddress = null;

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

    public function getPosition(): StaffPosition|null
    {
        return $this->position;
    }

    public function setPosition(StaffPosition|null $position): void
    {
        $this->position = $position;
    }

    public function getEmailAddress(): string|null
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string|null $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getEmailAddressToUse(): string|null
    {
        return $this->emailAddress ?? $this->person?->getEmailAddress();
    }
}
