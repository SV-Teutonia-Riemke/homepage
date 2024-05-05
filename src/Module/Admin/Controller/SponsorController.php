<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\SponsorType;
use App\Storage\Entity\Sponsor;
use App\Storage\Repository\SponsorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/sponsor', name: 'sponsor_')]
final class SponsorController extends AbstractCrudController
{
    public function __construct(
        private readonly SponsorRepository $sponsorRepository,
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

    #[Route('/{sponsor}/edit', name: 'edit')]
    public function edit(Request $request, Sponsor $sponsor): Response
    {
        return $this->handleEdit($request, $sponsor);
    }

    #[Route('/{sponsor}/remove', name: 'remove')]
    public function remove(Sponsor $sponsor): Response
    {
        return $this->handleRemove($sponsor);
    }

    #[Route('/{sponsor}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{sponsor}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Sponsor $sponsor, bool $enabled): Response
    {
        return $this->handleEnabled($sponsor, $enabled);
    }

    #[Route('/{sponsor}/up', name: 'up', defaults: ['position' => -1])]
    #[Route('/{sponsor}/down', name: 'down', defaults: ['position' => 1])]
    public function position(Sponsor $sponsor, int $position): Response
    {
        return $this->handlePosition($sponsor, $position);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->sponsorRepository,
            '@admin/sponsor/index.html.twig',
            '@admin/sponsor/create.html.twig',
            '@admin/sponsor/edit.html.twig',
            'app_admin_sponsor_index',
            'app_admin_sponsor_create',
            SponsorType::class,
            defaultSortFieldName: 'p.position',
            defaultSortDirection: 'asc',
        );
    }
}
