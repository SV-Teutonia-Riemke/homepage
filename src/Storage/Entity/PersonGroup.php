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

    #[ORM\ManyToMany(targetEntity: Person::class, inversedBy: 'groups', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $persons;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $enabled = true;

    public function __construct()
    {
        $this->persons = new ArrayCollection();
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

    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function addPerson(Person $person): void
    {
        if ($this->persons->contains($person)) {
            return;
        }

        $person->addGroup($this);
        $this->persons->add($person);
    }

    public function removePerson(Person $person): void
    {
        if (! $this->persons->contains($person)) {
            return;
        }

        $person->removeGroup($this);
        $this->persons->removeElement($person);
    }
}
