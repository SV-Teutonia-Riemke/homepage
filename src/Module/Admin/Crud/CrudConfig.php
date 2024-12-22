<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Exclude;

use function method_exists;
use function sprintf;

/** @template Entity of object */
#[Exclude]
final class CrudConfig
{
    /**
     * @param class-string<Entity> $dtoClass
     * @param array<string, mixed> $defaultRouteParams
     */
    public function __construct(
        public readonly string $dtoClass,
        private readonly string $baseRouteName,
        private readonly string|null $listRouteName = null,
        private readonly string|null $createRouteName = null,
        private readonly string|null $editRouteName = null,
        private readonly string|null $removeRouteName = null,
        private readonly string|null $upRouteName = null,
        private readonly string|null $downRouteName = null,
        private readonly string|null $enableRouteName = null,
        private readonly string|null $disableRouteName = null,
        private readonly array $defaultRouteParams = [],
        private readonly string|null $baseTemplateName = null,
        private readonly string|null $listTemplateName = null,
        private readonly string|null $createTemplateName = null,
        private readonly string|null $editTemplateName = null,
        public readonly string|null $defaultSortFieldName = null,
        public readonly string|null $defaultSortDirection = null,
        private readonly Closure|null $objectIdentifierCallable = null,
        public readonly Closure|null $formEmptyDataCallable = null,
    ) {
    }

    public function getListRouteName(): string
    {
        return $this->listRouteName ?? $this->buildRouteName('index');
    }

    public function getCreateRouteName(): string
    {
        return $this->createRouteName ?? $this->buildRouteName('create');
    }

    public function getEditRouteName(): string
    {
        return $this->editRouteName ?? $this->buildRouteName('edit');
    }

    public function getRemoveRouteName(): string
    {
        return $this->removeRouteName ?? $this->buildRouteName('remove');
    }

    public function getUpRouteName(): string
    {
        return $this->upRouteName ?? $this->buildRouteName('up');
    }

    public function getDownRouteName(): string
    {
        return $this->downRouteName ?? $this->buildRouteName('down');
    }

    public function getEnableRouteName(): string
    {
        return $this->enableRouteName ?? $this->buildRouteName('enable');
    }

    public function getDisableRouteName(): string
    {
        return $this->disableRouteName ?? $this->buildRouteName('disable');
    }

    public function getListTemplateName(): string
    {
        return $this->listTemplateName ?? $this->buildTemplateName('index');
    }

    public function getCreateTemplateName(): string
    {
        return $this->createTemplateName ?? $this->buildTemplateName('create');
    }

    public function getEditTemplateName(): string
    {
        return $this->editTemplateName ?? $this->buildTemplateName('edit');
    }

    /** @return array<string, string|int> */
    public function getDefaultRouteParams(): array
    {
        return $this->defaultRouteParams;
    }

    private function buildRouteName(string $suffix): string
    {
        return sprintf('app_admin_%s_%s', $this->baseRouteName, $suffix);
    }

    private function buildTemplateName(string $suffix): string
    {
        return sprintf('@admin/%s/%s.html.twig', $this->baseTemplateName ?? $this->baseRouteName, $suffix);
    }

    /** @param Entity $object */
    public function getObjectIdentifier(object $object): string|int
    {
        if ($this->objectIdentifierCallable === null) {
            if (! method_exists($object, 'getId')) {
                throw new RuntimeException(sprintf('The object of class "%s" must have a method "getId" to be used as an identifier.', $object::class));
            }

            return $object->getId();
        }

        return ($this->objectIdentifierCallable)($object);
    }
}
