<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use RuntimeException;

/** @template Entity of object */
class CrudConfigBuilder
{
    /** @var class-string<Entity>|null */
    public string|null $dtoClass                  = null;
    public string|null $listTemplate              = null;
    public string|null $createTemplate            = null;
    public string|null $editTemplate              = null;
    public string|null $baseRouteName             = null;
    public string|null $listRouteName             = null;
    public string|null $createRouteName           = null;
    public string|null $defaultSortFieldName      = null;
    public string|null $defaultSortDirection      = null;
    public Closure|null $objectIdentifierCallable = null;

    /**
     * @param class-string<Entity> $dtoClass
     *
     * @return self<Entity>
     */
    public function setMandatory(
        string $dtoClass,
        string $baseRouteName,
    ): self {
        $this->dtoClass      = $dtoClass;
        $this->baseRouteName = $baseRouteName;

        return $this;
    }

    /** @return CrudConfig<Entity> */
    public function build(): CrudConfig
    {
        $dtoClass = $this->dtoClass;
        if ($dtoClass === null) {
            throw new RuntimeException('DTO class is not set', 1715883146439);
        }

        $baseRouteName = $this->baseRouteName;
        if ($baseRouteName === null) {
            throw new RuntimeException('List route name is not set', 1715883146441);
        }

        return new CrudConfig(
            dtoClass: $dtoClass,
            baseRouteName: $baseRouteName,
            listRouteName: $this->listRouteName,
            createRouteName: $this->createRouteName,
            listTemplateName: $this->listTemplate,
            createTemplateName: $this->createTemplate,
            editTemplateName: $this->editTemplate,
            defaultSortFieldName: $this->defaultSortFieldName,
            defaultSortDirection: $this->defaultSortDirection,
            objectIdentifierCallable: $this->objectIdentifierCallable,
        );
    }
}
