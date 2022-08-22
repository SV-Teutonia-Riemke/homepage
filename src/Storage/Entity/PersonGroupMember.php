<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\PersonGroupMemberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonGroupMemberRepository::class)]
class PersonGroupMember extends AbstractEntity
{
    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Person $person = null;

    #[ORM\ManyToOne(targetEntity: PersonGroup::class, inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?PersonGroup $group = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $position = null;

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }

    public function getGroup(): ?PersonGroup
    {
        return $this->group;
    }

    public function setGroup(?PersonGroup $group): void
    {
        $this->group = $group;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): void
    {
        $this->position = $position;
    }
}
