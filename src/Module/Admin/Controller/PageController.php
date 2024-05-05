<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\PageType;
use App\Storage\Entity\Page;
use App\Storage\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/page', name: 'page_')]
final class PageController extends AbstractCrudController
{
    public function __construct(
        private readonly PageRepository $pageRepository,
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

    #[Route('/{page}/edit', name: 'edit')]
    public function edit(Request $request, Page $page): Response
    {
        return $this->handleEdit($request, $page);
    }

    #[Route('/{page}/remove', name: 'remove')]
    public function remove(Page $page): Response
    {
        return $this->handleRemove($page);
    }

    #[Route('/{page}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{page}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Page $page, bool $enabled): Response
    {
        return $this->handleEnabled($page, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->pageRepository,
            '@admin/page/index.html.twig',
            '@admin/page/create.html.twig',
            '@admin/page/edit.html.twig',
            'app_admin_page_index',
            'app_admin_page_create',
            PageType::class,
        );
    }
}
