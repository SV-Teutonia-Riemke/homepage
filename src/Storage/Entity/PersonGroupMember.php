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
    private Person|null $person = null;

    #[ORM\ManyToOne(targetEntity: PersonGroup::class, inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private PersonGroup|null $group = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $position = null;

    public function getPerson(): Person|null
    {
        return $this->person;
    }

    public function setPerson(Person|null $person): void
    {
        $this->person = $person;
    }

    public function getGroup(): PersonGroup|null
    {
        return $this->group;
    }

    public function setGroup(PersonGroup|null $group): void
    {
        $this->group = $group;
    }

    public function getPosition(): string|null
    {
        return $this->position;
    }

    public function setPosition(string|null $position): void
    {
        $this->position = $position;
    }
}
