<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\FullHandler;
use App\Admin\Crud\Handler\PositionHandler;
use App\Admin\Form\Type\Forms\DownloadType;
use App\Domain\Role;
use App\Storage\Entity\Download;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Download, DownloadType, null> */
#[IsGranted(Role::MANAGE_DOWNLOADS->value)]
#[Route('/download', name: 'download_')]
final class DownloadController extends AbstractCrudController
{
    use FullHandler;
    use PositionHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Download::class,
            'download',
        );
        $builder->defaultSortFieldName = 'p.position';
        $builder->defaultSortDirection = 'asc';
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return DownloadType::class;
    }
}
