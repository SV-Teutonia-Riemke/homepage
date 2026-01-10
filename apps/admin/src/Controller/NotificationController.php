<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Crud\CrudConfigBuilder;
use App\Admin\Crud\Handler\FullHandler;
use App\Admin\Form\Type\Forms\NotificationType;
use App\Domain\Role;
use App\Storage\Entity\Notification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/** @template-extends AbstractCrudController<Notification, NotificationType, null> */
#[IsGranted(Role::MANAGE_NOTIFICATIONS->value)]
#[Route('/notification', name: 'notification_')]
final class NotificationController extends AbstractCrudController
{
    use FullHandler;

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            Notification::class,
            'notification',
        );
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
        return NotificationType::class;
    }
}
