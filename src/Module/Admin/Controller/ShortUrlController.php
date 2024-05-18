<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Module\Admin\Crud\CrudConfig;
use App\Module\Admin\Crud\CrudConfigBuilder;
use App\Module\Admin\Crud\Handler\CRUDHandler;
use App\Module\Admin\Form\Type\Forms\ShortUrlType;
use RuntimeException;
use Shlinkio\Shlink\SDK\ShlinkClient;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrl;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrlCreation;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrlEdition;
use Shlinkio\Shlink\SDK\ShortUrls\Model\ShortUrlIdentifier;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
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
        $builder->createTemplate  = '@admin/shorturl/create.html.twig';
        $builder->editTemplate    = '@admin/shorturl/edit.html.twig';
        $builder->createRouteName = 'app_admin_shorturl_create';
    }

    protected function doLoadList(CrudConfig $crudConfig): mixed
    {
        return iterator_to_array($this->shlinkClient->listShortUrls());
    }

    protected function doLoadObject(CrudConfig $crudConfig, mixed $objectIdentifier): object|null
    {
        return $this->shlinkClient->getShortUrl(ShortUrlIdentifier::fromShortCode($objectIdentifier));
    }

    protected function doHandleValidCreateForm(Request $request, FormInterface $form, $data): void
    {
        $creation = ShortUrlCreation::forLongUrl($form->get('longUrl')->getData());

        $this->shlinkClient->createShortUrl($creation);
    }

    protected function doHandleValidEditForm(Request $request, FormInterface $form, $data): void
    {
        $edition = ShortUrlEdition::create();

        $this->shlinkClient->editShortUrl(
            ShortUrlIdentifier::fromShortUrl(
                $this->loadObject($request),
            ),
            $edition,
        );
    }

    protected function doCreatePersisting($object): void
    {
    }

    protected function doUpdatePersisting($object): void
    {
    }

    protected function doRemoving($object): void
    {
        $this->shlinkClient->deleteShortUrl(
            ShortUrlIdentifier::fromShortUrl($object),
        );
    }

    protected function getFormType(Request $request, object|null $object = null): string
    {
        return ShortUrlType::class;
    }

    protected function loadObject(Request $request): object
    {
        $objectIdentifier = $request->get('object');
        if ($objectIdentifier === null) {
            throw new RuntimeException('Object identifier is not set', 1715881423158);
        }

        return $this->shlinkClient->getShortUrl(ShortUrlIdentifier::fromShortCode($objectIdentifier));
    }
}
