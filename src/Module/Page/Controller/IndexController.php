<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Storage\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/', name: 'app_index')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $articleRepository
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('page/index.html.twig', [
            'articles' => $this->articleRepository->findAll(),
        ]);
    }
}
