<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use Doctrine\ORM\EntityRepository;

final class CrudConfig
{
    public function __construct(
        public readonly EntityRepository $entityRepository,
        public readonly string $listTemplate,
        public readonly string $createTemplate,
        public readonly string $editTemplate,
        public readonly string $listRouteName,
        public readonly string $createRouteName,
        public readonly string $formType,
        public readonly string|null $searchType = null,
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        public readonly Closure|null $handleForm = null,
    ) {
    }
}
