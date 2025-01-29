<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use Nicklog\ImgProxy\Options\AbstractOption;
use Nicklog\ImgProxy\Options\Background;
use Nicklog\ImgProxy\Options\Size;
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

    /** @var int<0, max>|null */
    public int|null $width = null;

    /** @var int<0, max>|null */
    public int|null $height = null;

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

    /** @return list<AbstractOption> */
    public function getFilterConfig(): array
    {
        $config = [];

        if ($this->width !== null || $this->height !== null) {
            $config[] = new Size($this->width, $this->height);
        }

        if ($this->backgroundColor !== null) {
            $config[] = Background::fromString($this->backgroundColor);
        }

        return $config;
    }

    /** @phpstan-param Options<array{id: string|null}> $options */
    private function normalizeFile(
        Options $options,
        int|File|null $fileOrId,
    ): File {
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
