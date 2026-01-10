<?php

declare(strict_types=1);

namespace App\Website\Controller;

use App\Infrastructure\Config\ConfigProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/imprint', name: 'imprint', options: ['sitemap' => true])]
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
