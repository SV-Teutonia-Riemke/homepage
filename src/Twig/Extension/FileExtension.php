<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Storage\Entity\File;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class FileExtension extends AbstractExtension
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('file_url', $this->getCallable()),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_url', $this->getCallable()),
        ];
    }

    private function getCallable(): callable
    {
        return fn (File $file, bool $download = false): string => $this->getFileUrl($file, $download);
    }

    private function getFileUrl(File $file, bool $download = false): string
    {
        return $this->urlGenerator->generate(
            'app_file',
            [
                'uuid'      => $file->getUuid()->__toString(),
                'name'      => $file->getSafeName(),
                'extension' => $file->getExtension(),
                'download'  => $download === true ? 1 : null,
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
