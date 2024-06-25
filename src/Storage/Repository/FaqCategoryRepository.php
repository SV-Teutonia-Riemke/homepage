<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\FaqCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<FaqCategory> */
class FaqCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaqCategory::class);
    }

    public function getFirst(): FaqCategory|null
    {
        return $this->createQueryBuilder('p')
            ->where('p.enabled = true')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @return array<FaqCategory> */
    public function findEnabled(): array
    {
        return $this->findBy(['enabled' => true], ['position' => 'ASC']);
    }
}
