<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\ConfigSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<ConfigSetting> */
final class ConfigSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfigSetting::class);
    }

    /** @return array<ConfigSetting> */
    public function findByNames(string ...$names): array
    {
        return $this->createQueryBuilder('s', 's.name')
            ->where('s.name IN (:names)')
            ->setParameter('names', $names, ArrayParameterType::STRING)
            ->getQuery()
            ->getResult();
    }
}
