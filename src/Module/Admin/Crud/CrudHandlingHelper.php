<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Spiriit\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\Form\FormInterface;

/** @template Entity of object */
class CrudHandlingHelper
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly FilterBuilderUpdaterInterface $filterBuilderUpdater,
    ) {
    }

    /** @param CrudConfig<Entity> $crudConfig */
    public function loadList(CrudConfig $crudConfig): mixed
    {
        return $crudConfig->getRepository($this->entityManager)->createQueryBuilder('p');
    }

    public function handlePostFiltering(FormInterface $form, QueryBuilder $builder): void
    {
        $this->filterBuilderUpdater->addFilterConditions($form, $builder);
    }

    /** @param Entity $object */
    public function handlePersisting($object): void
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    /** @param Entity $object */
    public function handleRemoving($object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
