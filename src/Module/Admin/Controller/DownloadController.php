<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\DownloadType;
use App\Storage\Entity\Download;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Download> */
#[AsController]
#[Route('/download', name: 'download_')]
final class DownloadController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setDefaults();
        $builder->dtoClass             = Download::class;
        $builder->formType             = DownloadType::class;
        $builder->listTemplate         = '@admin/download/index.html.twig';
        $builder->createTemplate       = '@admin/download/create.html.twig';
        $builder->editTemplate         = '@admin/download/edit.html.twig';
        $builder->listRouteName        = 'app_admin_download_index';
        $builder->createRouteName      = 'app_admin_download_create';
        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'desc';
    }
}
