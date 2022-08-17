<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;

#[ORM\Entity]
class Person extends AbstractEntity implements \Stringable
{
    #[ORM\Column(type: Types::STRING)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    private bool $anonymizeLastName = true;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $emailAddress = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $instagram = null;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): void
    {
        $this->facebook = $facebook;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        if($this->firstName !== null && $this->lastName !== null) {
            if($this->anonymizeLastName) {
                return sprintf('%s %s.', $this->firstName, u($this->lastName)->truncate(1)->toString());
            }

            return sprintf('%s %s', $this->firstName, $this->lastName);
        }

        return $this->firstName;
    }
}
