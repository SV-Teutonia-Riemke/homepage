<?php

declare(strict_types=1);

namespace App\Admin\Crud;

use Closure;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Exclude;

use function method_exists;
use function sprintf;

/** @template Entity of object */
#[Exclude]
final readonly class CrudConfig
{
    /**
     * @param class-string<Entity> $dtoClass
     * @param array<string, mixed> $defaultRouteParams
     */
    public function __construct(
        public string $dtoClass,
        private string $baseRouteName,
        private string|null $listRouteName = null,
        private string|null $createRouteName = null,
        private string|null $editRouteName = null,
        private string|null $removeRouteName = null,
        private string|null $upRouteName = null,
        private string|null $downRouteName = null,
        private string|null $enableRouteName = null,
        private string|null $disableRouteName = null,
        private array $defaultRouteParams = [],
        private string|null $baseTemplateName = null,
        private string|null $listTemplateName = null,
        private string|null $createTemplateName = null,
        private string|null $editTemplateName = null,
        public string|null $defaultSortFieldName = null,
        public string|null $defaultSortDirection = null,
        private Closure|null $objectIdentifierCallable = null,
        public Closure|null $formEmptyDataCallable = null,
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
        return sprintf('admin_%s_%s', $this->baseRouteName, $suffix);
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
