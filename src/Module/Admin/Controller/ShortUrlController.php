<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\ListHandler;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrl;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

use function iterator_to_array;

#[AsController]
#[Route('/shorturl', name: 'shorturl_')]
class ShortUrlController extends AbstractCrudController
{
    use ListHandler;

    public function __construct(
        private readonly ShlinkClient $shlinkClient,
    ) {
    }

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->dtoClass     = ShortUrl::class;
        $builder->listLoader   = fn () => iterator_to_array($this->shlinkClient->listShortUrls());
        $builder->listTemplate = '@admin/shorturl/index.html.twig';
    }
}
