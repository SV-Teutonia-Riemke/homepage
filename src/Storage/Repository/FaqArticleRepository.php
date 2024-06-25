<?php

declare(strict_types=1);

namespace App\Storage\Repository;

use App\Storage\Entity\FaqArticle;
use App\Storage\Entity\FaqCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/** @template-extends ServiceEntityRepository<FaqArticle> */
class FaqArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FaqArticle::class);
    }

    /** @return array<FaqArticle> */
    public function findEnabled(): array
    {
        return $this->findBy(['enabled' => true], ['position' => 'ASC']);
    }

    /** @return array<FaqArticle> */
    public function findEnabledByCategory(FaqCategory $faqCategory): array
    {
        return $this->findBy([
            'group' => $faqCategory->getId(),
            'enabled' => true,
        ], ['position' => 'ASC']);
    }
}
