<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LogicException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use function array_search;
use function array_unique;
use function array_values;
use function in_array;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User extends AbstractEntity implements PasswordAuthenticatedUserInterface, UserInterface
{
    /** @var list<string> */
    #[ORM\Column(type: 'json', nullable: true)]
    private array|null $roles = [];

    public function __construct(
        #[ORM\Column(type: Types::STRING, unique: true)]
        private string $email,
        #[ORM\Column(type: Types::STRING, nullable: true)]
        private string|null $password = null,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function setPassword(string|null $password): void
    {
        $this->password = $password;
    }

    /** @return list<string> */
    public function getRoles(): array
    {
        $roles   = $this->roles ?? [];
        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    public function hasRole(string $role): bool
    {
        return in_array($role, $this->getRoles(), true);
    }

    public function addRole(string $role): void
    {
        if ($this->hasRole($role)) {
            return;
        }

        $this->roles[] = $role;
    }

    public function removeRole(string $role): void
    {
        if (! $this->hasRole($role)) {
            return;
        }

        $roles = $this->getRoles();

        $key = array_search($role, $roles, true);
        unset($roles[$key]);

        $this->roles = array_values($roles);
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        if ($this->email === '') {
            throw new LogicException('The email of the user is null or empty. This should never happen.', 1734785239424);
        }

        return $this->email;
    }
}
