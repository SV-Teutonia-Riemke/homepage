<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\Form\FormInterface;

class CrudHandlingHelper
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FilterBuilderUpdaterInterface $filterBuilderUpdater,
    ) {
    }

    public function loadList(CrudConfig $crudConfig)
    {
        return $this->entityManager->getRepository($crudConfig->dtoClass)->createQueryBuilder('p');
    }

    public function handlePostFiltering(FormInterface $form, QueryBuilder $builder): void
    {
        $this->filterBuilderUpdater->addFilterConditions($form, $builder);
    }

    public function handlePersisting($object): void
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    public function handleRemoving($object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
