<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Download;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<Download> */
final class DownloadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Download::class);
    }

    /** @return array<Download> */
    public function findEnabled(): array
    {
        return $this->findBy([
            'enabled' => true,
        ], [
            'position' => 'ASC',
        ]);
    }
}
