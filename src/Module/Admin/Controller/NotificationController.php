<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Form\Type\Forms\NotificationType;
use App\Storage\Entity\Notification;
use App\Storage\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

use function assert;

#[AsController]
#[Route('/notification', name: 'app_admin_notification_')]
final class NotificationController extends AbstractController
{
    public function __construct(
        private readonly NotificationRepository $notificationRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly PaginatorInterface $paginator,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $query      = $this->notificationRepository->createQueryBuilder('p');
        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            options: [
                'defaultSortFieldName' => 'p.id',
                'defaultSortDirection' => 'desc',
            ]
        );

        return $this->render('@admin/notification/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(NotificationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification = $form->getData();
            assert($notification instanceof Notification);

            $this->entityManager->persist($notification);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_notification_index');
        }

        return $this->renderForm('@admin/notification/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{notification}/edit', name: 'edit')]
    public function edit(Request $request, Notification $notification): Response
    {
        $form = $this->createForm(NotificationType::class, $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($notification);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_notification_index');
        }

        return $this->renderForm('@admin/notification/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{notification}/remove', name: 'remove')]
    public function remove(Notification $notification): Response
    {
        $this->entityManager->remove($notification);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_notification_index');
    }

    #[Route('/{notification}/enable', name: 'enable', defaults: ['enabled' => true])]
    #[Route('/{notification}/disable', name: 'disable', defaults: ['enabled' => false])]
    public function changeEnabled(Notification $notification, bool $enabled): Response
    {
        $notification->setEnabled($enabled);

        $this->entityManager->flush();

        return $this->redirectToRoute('app_admin_notification_index');
    }
}
