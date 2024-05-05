<?php

declare(strict_types=1);

namespace App\Module\Page\Controller;

use App\Infrastructure\Config\ConfigProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/privacy-policies', name: 'privacy_policies', options: ['sitemap' => true])]
final class PrivacyPoliciesController extends AbstractController
{
    public function __construct(
        private readonly ConfigProvider $configProvider,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('@page/info/privacy_polices.html.twig', [
            'privacyPolicies' => $this->configProvider->get('privacy_polices'),
            'copyright'       => $this->configProvider->get('copyright'),
            'disclaimer'      => $this->configProvider->get('disclaimer'),
        ]);
    }
}
