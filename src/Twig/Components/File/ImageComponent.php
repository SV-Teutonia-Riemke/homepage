<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use App\Storage\Entity\File;
use App\Storage\Repository\FileRepository;
use RuntimeException;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

use function sprintf;

#[AsTwigComponent(
    name: 'file:image',
    template: 'components/file/image.htm.twig',
)]
class ImageComponent
{
    public int $id;
    public string $filter = 'default';

    public int|null $width  = null;
    public int|null $height = null;

    public function __construct(
        private readonly FileRepository $fileRepository,
    ) {
    }

    public function getImage(): File
    {
        $file = $this->fileRepository->find($this->id);

        if ($file === null) {
            throw new RuntimeException(sprintf('File with id %d not found', $this->id));
        }

        return $file;
    }

    public function getFilePath(): string
    {
        return $this->getImage()->getFilePath();
    }

    /** @return array<string, mixed> */
    public function getFilterConfig(): array
    {
        $config = [];

        if ($this->width !== null) {
            $config['relative_resize']['widen'] = $this->width;
        }

        if ($this->height !== null) {
            $config['relative_resize']['heighten'] = $this->height;
        }

        return $config;
    }
}
