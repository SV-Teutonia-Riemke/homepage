<?php

declare(strict_types=1);

namespace App\Infrastructure\Asset;

use App\Storage\Entity\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class AssetUrlGenerator
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(File $file, bool $download = false): string
    {
        return $this->urlGenerator->generate(
            'app_file',
            [
                'uuid'      => $file->getUuid()->__toString(),
                'name'      => $file->getSafeName(),
                'extension' => $file->getExtension(),
                'download'  => $download === true ? 1 : null,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
    }
}
