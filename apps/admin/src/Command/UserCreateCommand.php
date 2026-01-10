<?php

declare(strict_types=1);

namespace App\Admin\Command;

use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand('app:user:create')]
final readonly class UserCreateCommand
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
    ): int {
        $email = $io->ask('Email?', null, function (string $answer): string {
            $user = $this->userRepository->loadUserByIdentifier($answer);
            if ($user !== null) {
                throw new RuntimeException(
                    'A user with this user already exists',
                );
            }

            return $answer;
        });

        $password = $io->askHidden('Password?');

        $user = new User($email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
