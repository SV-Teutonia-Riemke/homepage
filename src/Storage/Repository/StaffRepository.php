<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Staff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Staff>
 */
final class StaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Staff::class);
    }
}
