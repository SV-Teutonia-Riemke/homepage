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

    /** @return list<Team> */
    public function findAllSeniors(): array
    {
        return $this->findBy([
            'ageCategory' => TeamAgeCategory::SENIOR,
        ], [
            'gender' => 'ASC',
            'name'   => 'ASC',
        ]);
    }

    /** @return list<Team> */
    public function findAllJuniors(): array
    {
        return $this->findBy([
            'ageCategory' => TeamAgeCategory::JUNIOR,
        ], [
            'gender' => 'ASC',
            'name'   => 'ASC',
        ]);
    }
}
