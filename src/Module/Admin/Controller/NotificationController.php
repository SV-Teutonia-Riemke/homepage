<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\FullHandler;
use App\Module\Admin\Form\Type\Forms\NotificationType;
use App\Storage\Entity\Notification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

/** @template-extends AbstractCrudController<Notification> */
#[AsController]
#[Route('/notification', name: 'notification_')]
final class NotificationController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->dtoClass             = Notification::class;
        $builder->listTemplate         = '@admin/notification/index.html.twig';
        $builder->createTemplate       = '@admin/notification/create.html.twig';
        $builder->editTemplate         = '@admin/notification/edit.html.twig';
        $builder->listRouteName        = 'app_admin_notification_index';
        $builder->createRouteName      = 'app_admin_notification_create';
        $builder->defaultSortFieldName = 'p.id';
        $builder->defaultSortDirection = 'desc';
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return NotificationType::class;
    }
}
