<?php

declare(strict_types=1);

namespace App\Security;

use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use function sprintf;

/** @template-implements UserProviderInterface<User> */
class UserProvider implements UserProviderInterface, PasswordUpgraderInterface, OAuthAwareUserProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $user = $this->userRepository->loadUserByIdentifier($identifier);
        if (! $user instanceof User) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (! $user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', $user::class));
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (! $user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /** @phpstan-return UserInterface */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        if ($response->getEmail() === null) {
            throw new UserNotFoundException();
        }

        return $this->loadUserByIdentifier($response->getEmail());
    }
}
