<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\LinkType;
use App\Storage\Entity\Link;
use App\Storage\Repository\LinkRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/link', name: 'link_')]
final class LinkController extends AbstractCrudController
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
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

    #[Route('/{link}/edit', name: 'edit')]
    public function edit(Request $request, Link $link): Response
    {
        return $this->handleEdit($request, $link);
    }

    #[Route('/{link}/remove', name: 'remove')]
    public function remove(Link $link): Response
    {
        return $this->handleRemove($link);
    }

    #[Route('/{link}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{link}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Link $link, bool $enabled): Response
    {
        return $this->handleEnabled($link, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->linkRepository,
            '@admin/link/index.html.twig',
            '@admin/link/create.html.twig',
            '@admin/link/edit.html.twig',
            'app_admin_link_index',
            'app_admin_link_create',
            LinkType::class,
            defaultSortFieldName: 'p.id',
            defaultSortDirection: 'desc',
        );
    }
}
