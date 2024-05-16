<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\ShortUrlType;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrl;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

use function iterator_to_array;

/** @template-extends AbstractCrudController<ShortUrl> */
#[AsController]
#[Route('/shorturl', name: 'shorturl_')]
class ShortUrlController extends AbstractCrudController
{
    use CRUDHandler;

    public function __construct(
        private readonly ShlinkClient $shlinkClient,
    ) {
    }

    protected function configureCrudConfig(CrudConfigBuilder $builder): void
    {
        $builder->setMandatory(
            ShortUrl::class,
            '@admin/shorturl/index.html.twig',
            'app_admin_shorturl_index',
        );
        $builder->listLoader      = fn () => iterator_to_array($this->shlinkClient->listShortUrls());
        $builder->createTemplate  = '@admin/shorturl/create.html.twig';
        $builder->editTemplate    = '@admin/shorturl/edit.html.twig';
        $builder->createRouteName = 'app_admin_shorturl_create';
        $builder->formType        = ShortUrlType::class;
    }
}
