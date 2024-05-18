<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;
use RuntimeException;

/** @template Entity of object */
class CrudConfigBuilder
{
    /** @var class-string<Entity>|null */
    public string|null $dtoClass             = null;
    public string|null $listTemplate         = null;
    public string|null $createTemplate       = null;
    public string|null $editTemplate         = null;
    public string|null $listRouteName        = null;
    public string|null $createRouteName      = null;
    public string|null $defaultSortFieldName = null;
    public string|null $defaultSortDirection = null;
    public Closure|null $handleForm          = null;

    /**
     * @param class-string<Entity> $dtoClass
     *
     * @return self<Entity>
     */
    public function setMandatory(
        string $dtoClass,
        string $listTemplate,
        string $listRouteName,
    ): self {
        $this->dtoClass      = $dtoClass;
        $this->listTemplate  = $listTemplate;
        $this->listRouteName = $listRouteName;

        return $this;
    }

    /** @return CrudConfig<Entity> */
    public function build(): CrudConfig
    {
        $dtoClass = $this->dtoClass;
        if ($dtoClass === null) {
            throw new RuntimeException('DTO class is not set', 1715883146439);
        }

        $listTemplate = $this->listTemplate;
        if ($listTemplate === null) {
            throw new RuntimeException('List template is not set', 1715883146440);
        }

        $listRouteName = $this->listRouteName;
        if ($listRouteName === null) {
            throw new RuntimeException('List route name is not set', 1715883146441);
        }

        return new CrudConfig(
            dtoClass: $dtoClass,
            listTemplate: $listTemplate,
            listRouteName: $listRouteName,
            createTemplate: $this->createTemplate,
            editTemplate: $this->editTemplate,
            createRouteName: $this->createRouteName,
            defaultSortFieldName: $this->defaultSortFieldName,
            defaultSortDirection: $this->defaultSortDirection,
            handleForm: $this->handleForm,
        );
    }
}
