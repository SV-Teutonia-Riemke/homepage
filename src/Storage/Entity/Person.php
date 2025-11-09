<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\PersonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;
use Stringable;

use function sprintf;
use function Symfony\Component\String\u;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ORM\UniqueConstraint(fields: [
    'firstName',
    'lastName',
])]
class Person extends AbstractEntity implements Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private string|null $firstName = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $lastName = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $anonymizeLastName = true;

    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private File|null $image = null;

    #[ORM\Column(type: PhoneNumberType::NAME, nullable: true)]
    private PhoneNumber|null $phoneNumber = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $emailAddress = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $facebook = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private string|null $instagram = null;

    public function getFirstName(): string|null
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string|null
    {
        return $this->lastName;
    }

    public function setLastName(string|null $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function isAnonymizeLastName(): bool
    {
        return $this->anonymizeLastName;
    }

    public function setAnonymizeLastName(bool $anonymizeLastName): void
    {
        $this->anonymizeLastName = $anonymizeLastName;
    }

    public function getImage(): File|null
    {
        return $this->image;
    }

    public function setImage(File|null $image): void
    {
        $this->image = $image;
    }

    public function getPhoneNumber(): PhoneNumber|null
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(PhoneNumber|null $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmailAddress(): string|null
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(string|null $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
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

    public function getAnonymizedName(): string
    {
        if ($this->firstName !== null && $this->lastName !== null) {
            return sprintf('%s %s.', $this->firstName, u($this->lastName)->truncate(1)->toString());
        }

        return $this->firstName;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }

    public function __toString(): string
    {
        if ($this->firstName !== null && $this->lastName !== null) {
            return sprintf('%s %s', $this->firstName, $this->lastName);
        }

        return (string) $this->firstName;
    }
}
