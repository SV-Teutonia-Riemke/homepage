<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Domain\TeamAgeCategory;
use App\Storage\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<Team> */
final class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /** @return array<int, Team> */
    public function findAllEnabled(): array
    {
        return $this->findBy([
            'enabled'     => true,
        ], [
            'gender' => 'ASC',
            'name'   => 'ASC',
        ]);
    }

    /** @return array<int, Team> */
    public function findAllSeniors(): array
    {
        return $this->findBy([
            'ageCategory' => TeamAgeCategory::SENIOR,
            'enabled'     => true,
        ], [
            'gender' => 'ASC',
            'name'   => 'ASC',
        ]);
    }

    /** @return array<int, Team> */
    public function findAllJuniors(): array
    {
        return $this->findBy([
            'ageCategory' => TeamAgeCategory::JUNIOR,
            'enabled'     => true,
        ], [
            'gender'    => 'ASC',
            'juniorAge' => 'ASC',
        ]);
    }
}
