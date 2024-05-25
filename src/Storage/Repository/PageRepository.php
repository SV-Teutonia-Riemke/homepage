<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<Page> */
final class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /** @return array<Page> */
    public function findEnabled(): array
    {
        return $this->findBy(['enabled' => true]);
    }
}
