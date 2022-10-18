<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\PersonGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonGroupRepository::class)]
class PersonGroup extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    /** @var Collection<PersonGroupMember> */
    #[ORM\OneToMany(mappedBy: 'group', targetEntity: PersonGroupMember::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $members;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $enabled = true;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /** @return Collection<PersonGroupMember> */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(PersonGroupMember|null $member): void
    {
        if ($member === null) {
            return;
        }

        if ($this->members->contains($member)) {
            return;
        }

        $member->setGroup($this);
        $this->members->add($member);
    }

    public function removeMember(PersonGroupMember $member): void
    {
        if (! $this->members->contains($member)) {
            return;
        }

        $this->members->removeElement($member);
    }
}
