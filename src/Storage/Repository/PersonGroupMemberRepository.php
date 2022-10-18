<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\PersonGroup;
use App\Storage\Entity\PersonGroupMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<PersonGroup> */
final class PersonGroupMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonGroupMember::class);
    }
}
