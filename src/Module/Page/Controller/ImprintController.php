<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Infrastructure\Config\ConfigProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/imprint', name: 'app_imprint', options: ['sitemap' => true])]
final class ImprintController extends AbstractController
{
    public function __construct(
        private readonly ConfigProvider $configProvider,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('@page/info/imprint.html.twig', [
            'imprint' => $this->configProvider->get('imprint'),
        ]);
    }
}
