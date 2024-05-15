<?php

declare(strict_types=1);

namespace App\Module\Admin\Crud;

use Closure;

class CrudConfigBuilder
{
    public string|null $dtoClass                 = null;
    public string|null $listTemplate             = null;
    public string|null $createTemplate           = null;
    public string|null $editTemplate             = null;
    public string|null $listRouteName            = null;
    public string|null $createRouteName          = null;
    public string|Closure|null $formType         = null;
    public string|null $searchType               = null;
    public string|null $defaultSortFieldName     = null;
    public string|null $defaultSortDirection     = null;
    public Closure|null $handleForm              = null;
    public Closure|null $listLoader              = null;
    public Closure|null $handlePersisting        = null;
    public Closure|null $handleRemoving          = null;
    public Closure|null $handlePreFiltering      = null;
    public Closure|null $handlePostFiltering     = null;
    public Closure|null $handlePaginationOptions = null;

    public function __construct(
        private readonly CrudHandlingHelper $crudHandlingHelper,
    ) {
    }

    public function setDefaults(): void
    {
        $this->listLoader          = $this->crudHandlingHelper->loadList(...);
        $this->handlePostFiltering = $this->crudHandlingHelper->handlePostFiltering(...);
        $this->handlePersisting    = $this->crudHandlingHelper->handlePersisting(...);
        $this->handleRemoving      = $this->crudHandlingHelper->handleRemoving(...);
    }

    public function build(): CrudConfig
    {
        return new CrudConfig(
            dtoClass: $this->dtoClass,
            listTemplate: $this->listTemplate,
            createTemplate: $this->createTemplate,
            editTemplate: $this->editTemplate,
            listRouteName: $this->listRouteName,
            createRouteName: $this->createRouteName,
            formType: $this->formType,
            searchType: $this->searchType,
            defaultSortFieldName: $this->defaultSortFieldName,
            defaultSortDirection: $this->defaultSortDirection,
            handleForm: $this->handleForm,
            listLoader: $this->listLoader,
            handlePersisting: $this->handlePersisting,
            handleRemoving: $this->handleRemoving,
            handlePreFiltering: $this->handlePreFiltering,
            handlePostFiltering: $this->handlePostFiltering,
            handlePaginationOptions: $this->handlePaginationOptions,
        );
    }
}
