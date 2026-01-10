<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use Shlinkio\Shlink\SDK\ShlinkClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function count;

#[Route('/', name: 'index')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ShlinkClient|null $shlinkClient,
    ) {
    }

    public function __invoke(): Response
    {
        if ($this->shlinkClient !== null) {
            $visitsOverview = $this->shlinkClient->getVisitsOverview();
            $shortUrlsCount = $this->shlinkClient->listShortUrls()->count();
            $tagsCount      = count($this->shlinkClient->listTags());
        }

        return $this->render('@admin/index.html.twig', [
            'visitsOverview' => $visitsOverview ?? null,
            'shortUrlsCount' => $shortUrlsCount ?? 0,
            'tagsCount' => $tagsCount ?? 0,
        ]);
    }
}
