<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Sponsor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<Sponsor> */
final class SponsorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sponsor::class);
    }

    /** @return array<int, Sponsor> */
    public function findEnabled(): array
    {
        return $this->findBy([
            'enabled' => true,
        ], [
            'position' => 'ASC',
        ]);
    }
}
