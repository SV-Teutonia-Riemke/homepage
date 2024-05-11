<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\File;
use App\Storage\Repository\FileRepository;
use RuntimeException;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function sprintf;

#[AsTwigComponent(
    name: 'file:link',
    template: 'components/file/link.htm.twig',
)]
class LinkComponent
{
    public int $id;
    public string|null $label = null;
    public bool $download     = false;

    public function __construct(
        private readonly AssetUrlGenerator $assetUrlGenerator,
        private readonly FileRepository $fileRepository,
    ) {
    }

    public function getFile(): File
    {
        $file = $this->fileRepository->find($this->id);

        if ($file === null) {
            throw new RuntimeException(sprintf('File with id %d not found', $this->id));
        }

        return $file;
    }

    public function getUrl(): string
    {
        return $this->assetUrlGenerator->__invoke(
            $this->getFile(),
            $this->download,
        );
    }
}
