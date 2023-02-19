<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Repository\PersonGroupMemberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PersonGroupMemberRepository::class)]
class PersonGroupMember extends AbstractEntity implements PositionInterface
{
    use Position;

    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private Person|null $person = null;

    #[Gedmo\SortableGroup]
    #[ORM\ManyToOne(targetEntity: PersonGroup::class, inversedBy: 'members')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private PersonGroup|null $group = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $jobTitle = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $provisional = false;

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

    public function getJobTitle(): string|null
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string|null $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function isProvisional(): bool
    {
        return $this->provisional;
    }

    public function setProvisional(bool $provisional): void
    {
        $this->provisional = $provisional;
    }
}
