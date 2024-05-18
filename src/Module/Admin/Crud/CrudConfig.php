<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use Symfony\Component\Form\FormInterface;

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
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        private readonly Closure|null $handleForm = null,
    ) {
    }

    /** @param (Entity)|array<array-key, mixed> $data */
    public function runHandleForm(FormInterface $form, array|object $data): void
    {
        if ($this->handleForm === null) {
            return;
        }

        ($this->handleForm)($form, $data);
    }
}
