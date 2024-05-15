<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use LogicException;
use Symfony\Component\HttpFoundation\Request;

use function is_string;

/** @template Entity of object */
final class CrudConfig
{
    public function __construct(
        public readonly string $dtoClass,
        public readonly string $listTemplate,
        public readonly string|null $createTemplate,
        public readonly string|null $editTemplate,
        public readonly string|null $listRouteName,
        public readonly string|null $createRouteName,
        private readonly string|Closure|null $formType,
        public readonly string|null $searchType = null,
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        public readonly Closure|null $handleForm = null,
        public readonly Closure|null $listLoader = null,
        public readonly Closure|null $handlePersisting = null,
        public readonly Closure|null $handleRemoving = null,
        public readonly Closure|null $handlePreFiltering = null,
        public readonly Closure|null $handlePostFiltering = null,
        public readonly Closure|null $handlePaginationOptions = null,
    ) {
    }

    public function hasFormType(): bool
    {
        return $this->formType !== null;
    }

    public function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        if ($this->formType === null) {
            throw new LogicException('FormType is not set');
        }

        if (is_string($this->formType)) {
            return $this->formType;
        }

        return ($this->formType)($request, $object);
    }

    public function hasSearchType(): bool
    {
        return $this->searchType !== null;
    }

    public function getSearchType(): string
    {
        if ($this->searchType === null) {
            throw new LogicException('SearchType is not set');
        }

        return $this->searchType;
    }
}
