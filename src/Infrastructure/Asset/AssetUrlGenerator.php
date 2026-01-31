<?php

declare(strict_types=1);

namespace App\Infrastructure\Asset;

use App\Storage\Entity\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class AssetUrlGenerator
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(
        File $file,
        bool $download = false,
    ): string {
        return $this->urlGenerator->generate(
            'file',
            [
                'uuid'      => $file->getUuid()->toRfc4122(),
                'name'      => $file->getSafeName(),
                'extension' => $file->getExtension(),
                'download'  => $download ? 1 : null,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );
    }
}
