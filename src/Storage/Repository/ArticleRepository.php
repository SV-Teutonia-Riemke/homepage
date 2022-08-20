<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Article>
 */
final class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return list<Article>
     */
    public function findNewestEnabled(): array
    {
        return $this->findBy([
            'enabled' => true,
        ], [
            'createdAt' => 'desc',
        ], 10);
    }
}
