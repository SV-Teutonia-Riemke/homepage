<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\Directory;
use App\Storage\Entity\File;
use App\Storage\Repository\DirectoryRepository;
use App\Storage\Repository\FileRepository;
use Twig\Attribute\AsTwigFilter;
use Twig\Attribute\AsTwigFunction;
use Twig\Attribute\AsTwigTest;

use function in_array;
use function is_int;

final readonly class FileExtension
{
    public function __construct(
        private AssetUrlGenerator $assetUrlGenerator,
        private DirectoryRepository $directoryRepository,
        private FileRepository $fileRepository,
    ) {
    }

    #[AsTwigTest('image')]
    public function isImage(File $file): bool
    {
        return in_array(
            $file->getExtension(),
            ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            true,
        );
    }

    #[AsTwigFunction('file_url')]
    #[AsTwigFilter('file_url')]
    public function fileUrl(
        File $file,
        bool $download = false,
    ): string {
        return $this->assetUrlGenerator->__invoke($file, $download);
    }

    #[AsTwigFunction('find_directory')]
    public function findDirectory(int $id): Directory|null
    {
        return $this->directoryRepository->find($id);
    }

    #[AsTwigFunction('find_file')]
    public function findFile(int $id): File|null
    {
        return $this->fileRepository->find($id);
    }

    /** @return iterable<File> */
    #[AsTwigFilter('directory_files')]
    #[AsTwigFunction('directory_files')]
    public function findFilesOfDirectory(
        int|Directory $directory,
        bool $deepFiles = true,
    ): iterable {
        if (is_int($directory)) {
            $directory = $this->directoryRepository->find($directory);
        }

        if ($directory === null) {
            return [];
        }

        return $deepFiles ? $directory->getDeepFiles() : $directory->getFiles();
    }
}
