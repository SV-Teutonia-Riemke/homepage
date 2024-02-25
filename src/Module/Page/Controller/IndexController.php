<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Repository\ArticleRepository;
use App\Storage\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/', name: 'app_index', options: ['sitemap' => true])]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly NotificationRepository $notificationRepository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        return $this->render('@page/index.html.twig', [
            'articles'      => $this->articleRepository->findLatestEnabled(2),
            'notifications' => $this->notificationRepository->findEnabled(),
        ]);
    }
}
