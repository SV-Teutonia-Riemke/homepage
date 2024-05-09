<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Infrastructure\Menu\MenuGroup;
use App\Storage\Entity\MenuItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<MenuItem> */
class MenuItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItem::class);
    }

    /** @return array<MenuItem> */
    public function findByGroupAndEnabled(MenuGroup $group): array
    {
        return $this->getEntityManager()
            ->createQuery(
                <<<'DQL'
                    SELECT m
                    FROM App\Storage\Entity\MenuItem m
                    WHERE m.group = :group
                    AND m.enabled = true
                    ORDER BY m.position ASC    
                DQL,
            )
            ->setParameter('group', $group->value, Types::STRING)
            ->getResult();
    }
}
