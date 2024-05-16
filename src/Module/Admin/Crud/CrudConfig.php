<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LogicException;
use RuntimeException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use function is_string;

/** @template Entity of object */
final class CrudConfig
{
    /** @param class-string<Entity> $dtoClass */
    public function __construct(
        public readonly string $dtoClass,
        public readonly string $listTemplate,
        public readonly string $listRouteName,
        public readonly string|null $createTemplate,
        public readonly string|null $editTemplate,
        public readonly string|null $createRouteName,
        private readonly string|Closure|null $formType,
        public readonly string|null $searchType = null,
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        private readonly Closure|null $handleForm = null,
        private readonly Closure|null $listLoader = null,
        private readonly Closure|null $handlePersisting = null,
        private readonly Closure|null $handleRemoving = null,
        private readonly Closure|null $handlePreFiltering = null,
        private readonly Closure|null $handlePostFiltering = null,
        private readonly Closure|null $handlePaginationOptions = null,
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

    public function runListLoader(Request $request): mixed
    {
        if ($this->listLoader === null) {
            throw new RuntimeException('List loader is not set', 1715882212078);
        }

        return ($this->listLoader)($this, $request);
    }

    /** @param (Entity)|array<array-key, mixed> $data */
    public function runHandleForm(FormInterface $form, array|object $data): void
    {
        if ($this->handleForm === null) {
            return;
        }

        ($this->handleForm)($form, $data);
    }

    /** @param Entity $data */
    public function runPersisting(object $data): void
    {
        if ($this->handlePersisting === null) {
            return;
        }

        ($this->handlePersisting)($data);
    }

    /** @param Entity $data */
    public function runHandleRemoving(object $data): void
    {
        if ($this->handleRemoving === null) {
            return;
        }

        ($this->handleRemoving)($data);
    }

    public function runHandlePreFiltering(FormInterface $form): void
    {
        if ($this->handlePreFiltering === null) {
            return;
        }

        ($this->handlePreFiltering)($form);
    }

    public function runHandlePostFiltering(FormInterface $form, mixed $list): void
    {
        if ($this->handlePostFiltering === null) {
            return;
        }

        ($this->handlePostFiltering)($form, $list);
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    public function runHandlePaginationOptions(Request $request, array $options): array
    {
        if ($this->handlePaginationOptions === null) {
            return $options;
        }

        return ($this->handlePaginationOptions)($request, $options);
    }

    /** @return EntityRepository<Entity> */
    public function getRepository(EntityManagerInterface $entityManager): EntityRepository
    {
        return $entityManager->getRepository($this->dtoClass);
    }
}
