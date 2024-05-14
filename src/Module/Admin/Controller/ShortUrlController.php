<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use Shlinkio\Shlink\SDK\ShlinkClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shorturl', name: 'shorturl_')]
class ShortUrlController extends AbstractController
{
    public function __construct(
        private readonly ShlinkClient $shlinkClient,
    ) {
    }

    #[Route('', name: 'index')]
    public function index(Request $request): Response
    {
        $allShortUrls = $this->shlinkClient->listShortUrls();

        return $this->render('@admin/shorturl/index.html.twig', [
            'iterable' => $allShortUrls,
        ]);
    }
}
