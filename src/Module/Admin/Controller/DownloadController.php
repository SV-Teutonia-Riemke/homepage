<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\DownloadType;
use App\Storage\Entity\Download;
use App\Storage\Repository\DownloadRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Download> */
#[AsController]
#[Route('/download', name: 'download_')]
final class DownloadController extends AbstractCrudController
{
    public function __construct(
        private readonly DownloadRepository $downloadRepository,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        return $this->handleList($request);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        return $this->handleCreate($request);
    }

    #[Route('/{download}/edit', name: 'edit')]
    public function edit(Request $request, Download $download): Response
    {
        return $this->handleEdit($request, $download);
    }

    #[Route('/{download}/remove', name: 'remove')]
    public function remove(Download $download): Response
    {
        return $this->handleRemove($download);
    }

    #[Route('/{download}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{download}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Download $download, bool $enabled): Response
    {
        return $this->handleEnabled($download, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->downloadRepository,
            '@admin/download/index.html.twig',
            '@admin/download/create.html.twig',
            '@admin/download/edit.html.twig',
            'app_admin_download_index',
            'app_admin_download_create',
            DownloadType::class,
            defaultSortFieldName: 'p.id',
            defaultSortDirection: 'desc',
        );
    }
}
