<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

use function is_string;

/** @template Entity of object */
final class CrudConfig
{
    /** @param EntityRepository<Entity> $entityRepository */
    public function __construct(
        public readonly EntityRepository $entityRepository,
        public readonly string $listTemplate,
        public readonly string $createTemplate,
        public readonly string $editTemplate,
        public readonly string $listRouteName,
        public readonly string $createRouteName,
        private readonly string|Closure $formType,
        public readonly string|null $searchType = null,
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        public readonly Closure|null $handleForm = null,
    ) {
    }

    public function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        if (is_string($this->formType)) {
            return $this->formType;
        }

        return ($this->formType)($request, $object);
    }
}
