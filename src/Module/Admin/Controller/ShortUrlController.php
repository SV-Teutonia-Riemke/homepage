<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;

use App\Domain\Role;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;

use function iterator_to_array;

/** @template-extends AbstractCrudController<ShortUrl, ShortUrlType, null> */
#[AsController]
#[IsGranted(Role::MANAGE_SHORT_URLS->value)]
#[Route('/shorturl', name: 'shorturl_')]
class ShortUrlController extends AbstractCrudController
{
    use CRUDHandler;

    public function __construct(
        private readonly ShlinkClient $shlinkClient,
    ) {
    }

    protected function configureCrudConfig(
        CrudConfigBuilder $builder,
        Request $request,
    ): void {
        $builder->setMandatory(
            ShortUrl::class,
            'shorturl',
        );
        $builder->objectIdentifierCallable = static fn (ShortUrl $shortUrl): string => $shortUrl->shortCode;
    }

    protected function doLoadList(CrudConfig $crudConfig): mixed
    {
        return iterator_to_array($this->shlinkClient->listShortUrls());
    }

    protected function doLoadObject(
        CrudConfig $crudConfig,
        mixed $objectIdentifier,
    ): object|null {
        return $this->shlinkClient->getShortUrl(ShortUrlIdentifier::fromShortCode($objectIdentifier));
    }

    protected function doHandleValidCreateForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        if (! $data instanceof \App\Module\Admin\Misc\Shlink\ShortUrl) {
            throw new RuntimeException('Invalid data type', 1716126888221);
        }

        $creation = ShortUrlCreation::forLongUrl($data->longUrl)
            ->returnExistingMatchingShortUrl();

        if ($data->shortCode !== null) {
            $creation = $creation->withCustomSlug($data->shortCode);
        }

        if ($data->containsTags()) {
            $creation = $creation->withTags(...$data->getTagsAsArray());
        }

        $this->shlinkClient->createShortUrl($creation);
    }

    protected function doHandleValidEditForm(
        Request $request,
        FormInterface $form,
        mixed $data,
    ): void {
        if (! $data instanceof \App\Module\Admin\Misc\Shlink\ShortUrl) {
            throw new RuntimeException('Invalid data type', 1716126888220);
        }

        $shlinkShortUrl = $this->loadObject($request);
        $identifier     = ShortUrlIdentifier::fromShortUrl($shlinkShortUrl);

        $edition = ShortUrlEdition::create()
            ->withLongUrl($data->longUrl);

        if ($data->containsTags()) {
            $edition = $edition->withTags(...$data->getTagsAsArray());
        }

        $this->shlinkClient->editShortUrl(
            $identifier,
            $edition,
        );
    }

    protected function doCreatePersisting(object $object): void
    {
    }

    protected function doUpdatePersisting(object $object): void
    {
    }

    protected function doMapToFormDto(object $object): mixed
    {
        return \App\Module\Admin\Misc\Shlink\ShortUrl::fromShlink($object);
    }

    protected function doRemoving(object $object): void
    {
        $this->shlinkClient->deleteShortUrl(
            ShortUrlIdentifier::fromShortUrl($object),
        );
    }

    protected function getFormType(
        Request $request,
        object|null $object = null,
    ): string {
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
