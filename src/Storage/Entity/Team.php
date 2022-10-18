<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Domain\Gender;
use App\Domain\TeamAgeCategory;
use App\Domain\TeamJuniorAge;
use App\Storage\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function usort;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team extends AbstractEntity
{
    #[ORM\Column(type: Types::STRING)]
    private string $name;

    #[ORM\Column(type: Types::STRING, enumType: Gender::class)]
    private Gender $gender;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: TeamAgeCategory::class)]
    private TeamAgeCategory $ageCategory;

    #[ORM\Column(type: Types::STRING, nullable: true, enumType: TeamJuniorAge::class)]
    private TeamJuniorAge|null $juniorAge = null;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    /** @var Collection<Player> */
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Player::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $players;

    /** @var Collection<Staff> */
    #[ORM\OneToMany(mappedBy: 'team', targetEntity: Staff::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $staffs;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $facebook = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $instagram = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $currentMatchday = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $handballNetId = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $enabled = true;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->staffs  = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
    }

    public function getAgeCategory(): TeamAgeCategory
    {
        return $this->ageCategory;
    }

    public function setAgeCategory(TeamAgeCategory $ageCategory): void
    {
        $this->ageCategory = $ageCategory;
    }

    public function getJuniorAge(): TeamJuniorAge|null
    {
        return $this->juniorAge;
    }

    public function setJuniorAge(TeamJuniorAge|null $juniorAge): void
    {
        $this->juniorAge = $juniorAge;
    }

    public function getImage(): File|null
    {
        return $this->image;
    }

    public function setImage(File|null $image): void
    {
        $this->image = $image;
    }

    public function getFacebook(): string|null
    {
        return $this->facebook;
    }

    public function setFacebook(string|null $facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getInstagram(): string|null
    {
        return $this->instagram;
    }

    public function setInstagram(string|null $instagram): void
    {
        $this->instagram = $instagram;
    }

    public function getCurrentMatchday(): string|null
    {
        return $this->currentMatchday;
    }

    public function setCurrentMatchday(string|null $currentMatchday): void
    {
        $this->currentMatchday = $currentMatchday;
    }

    public function getHandballNetId(): string|null
    {
        return $this->handballNetId;
    }

    public function setHandballNetId(string|null $handballNetId): void
    {
        $this->handballNetId = $handballNetId;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /** @return Collection<Player> */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    /** @return Collection<Player> */
    public function getPlayersByNumber(): Collection
    {
        $data = $this->players->toArray();

        usort(
            $data,
            static function (Player $a, Player $b): int {
                if ($a->getNumber() === null) {
                    return 1;
                }

                if ($b->getNumber() === null) {
                    return -1;
                }

                return $a->getNumber() <=> $b->getNumber();
            },
        );

        return new ArrayCollection($data);
    }

    public function addPlayer(Player|null $player): void
    {
        if ($player === null) {
            return;
        }

        if ($this->players->contains($player)) {
            return;
        }

        $player->setTeam($this);
        $this->players->add($player);
    }

    public function removePlayer(Player $player): void
    {
        if (! $this->players->contains($player)) {
            return;
        }

        $this->players->removeElement($player);
    }

    /** @return Collection<Staff> */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(Staff|null $staff): void
    {
        if ($staff === null) {
            return;
        }

        if ($this->staffs->contains($staff)) {
            return;
        }

        $staff->setTeam($this);
        $this->staffs->add($staff);
    }

    public function removeStaff(Staff $staff): void
    {
        if (! $this->staffs->contains($staff)) {
            return;
        }

        $this->staffs->removeElement($staff);
    }
}
