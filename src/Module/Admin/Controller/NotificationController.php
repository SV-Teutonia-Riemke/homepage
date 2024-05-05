<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Form\Type\Forms\NotificationType;
use App\Storage\Entity\Notification;
use App\Storage\Repository\NotificationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/notification', name: 'notification_')]
final class NotificationController extends AbstractCrudController
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
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

    #[Route('/{notification}/edit', name: 'edit')]
    public function edit(Request $request, Notification $notification): Response
    {
        return $this->handleEdit($request, $notification);
    }

    #[Route('/{notification}/remove', name: 'remove')]
    public function remove(Notification $notification): Response
    {
        return $this->handleRemove($notification);
    }

    #[Route('/{notification}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{notification}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Notification $notification, bool $enabled): Response
    {
        return $this->handleEnabled($notification, $enabled);
    }

    protected function getCrudConfig(): CrudConfig
    {
        return new CrudConfig(
            $this->notificationRepository,
            '@admin/notification/index.html.twig',
            '@admin/notification/create.html.twig',
            '@admin/notification/edit.html.twig',
            'app_admin_notification_index',
            'app_admin_notification_create',
            NotificationType::class,
            defaultSortFieldName: 'p.id',
            defaultSortDirection: 'desc',
        );
    }
}
