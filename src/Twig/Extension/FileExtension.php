<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\Directory;
use App\Storage\Entity\File;
use App\Storage\Repository\DirectoryRepository;
use App\Storage\Repository\FileRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

use function is_int;

final class FileExtension extends AbstractExtension
{
    public function __construct(
        private readonly AssetUrlGenerator $assetUrlGenerator,
        private readonly DirectoryRepository $directoryRepository,
        private readonly FileRepository $fileRepository,
    ) {
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        return [
            new TwigFilter('file_url', $this->assetUrlGenerator->__invoke(...)),
            new TwigFilter('directory_files', $this->findFilesOfDirectory(...)),
        ];
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_url', $this->assetUrlGenerator->__invoke(...)),
            new TwigFunction('directory_files', $this->findFilesOfDirectory(...)),
            new TwigFunction('find_file', $this->fileRepository->find(...)),
            new TwigFunction('find_directory', $this->directoryRepository->find(...)),
        ];
    }

    /** @return iterable<File> */
    private function findFilesOfDirectory(int|Directory $directory, bool $deepFiles = true): iterable
    {
        if (is_int($directory)) {
            $directory = $this->directoryRepository->find($directory);
        }

        if ($directory === null) {
            return [];
        }

        return $deepFiles ? $directory->getDeepFiles() : $directory->getFiles();
    }
}
