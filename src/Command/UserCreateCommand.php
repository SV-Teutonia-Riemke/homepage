<?php

declare(strict_types=1);

namespace App\Command;

use App\Storage\Entity\User;
use App\Storage\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand('app:user:create')]
final class UserCreateCommand
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(
        SymfonyStyle $io,
    ): int {
        $email = $io->ask('Email?', null, function ($answer) {
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
