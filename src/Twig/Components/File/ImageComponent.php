<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use App\Storage\Entity\File;
use App\Storage\Repository\FileRepository;
use App\Twig\Components\AbstractComponent;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'file:image',
    template: 'components/file/image.htm.twig',
)]
class ImageComponent extends AbstractComponent
{
    public File $file;
    public string $filter = 'default';

    public int|null $width              = null;
    public int|null $height             = null;
    public string|null $backgroundColor = null;

    public function __construct(
        private readonly FileRepository $fileRepository,
    ) {
    }

    protected function configureProps(OptionsResolver $resolver): void
    {
        $resolver->define('id')
            ->default(null)
            ->allowedTypes('int', 'null');

        $resolver->define('file')
            ->required()
            ->allowedTypes('int', File::class)
            ->default(static fn (Options $options, int|File|null $fileOrId) => $fileOrId ?? $options['id'])
            ->normalize($this->normalizeFile(...));
    }

    public function getFilePath(): string
    {
        return $this->file->getFilePath();
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

        if ($this->backgroundColor !== null) {
            $config['background']['color'] = $this->backgroundColor;
        }

        return $config;
    }

    private function normalizeFile(Options $options, int|File|null $fileOrId): File
    {
        $fileOrId = $options['id'] ?? $fileOrId;

        if ($fileOrId instanceof File) {
            return $fileOrId;
        }

        $file = $this->fileRepository->find($fileOrId);

        if ($file === null) {
            throw new InvalidArgumentException('File not found');
        }

        return $file;
    }
}
