<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<Link> */
final class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    /** @return array<int, Link> */
    public function findEnabled(): array
    {
        return $this->findBy([
            'enabled' => true,
        ], [
            'position' => 'ASC',
        ]);
    }
}
