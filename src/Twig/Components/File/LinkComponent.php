<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use App\Infrastructure\Asset\AssetUrlGenerator;
use App\Storage\Entity\File;
use App\Storage\Repository\FileRepository;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent(
    name: 'file:link',
    template: 'components/file/link.htm.twig',
)]
class LinkComponent
{
    public File $file;
    public string|null $label = null;
    public bool $download     = false;

    public function __construct(
        private readonly AssetUrlGenerator $assetUrlGenerator,
        private readonly FileRepository $fileRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    #[PreMount]
    public function validate(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setIgnoreUndefined();

        $resolver->define('id')
            ->default(null)
            ->allowedTypes('int', 'null');

        $resolver->define('file')
            ->required()
            ->allowedTypes('int', File::class)
            ->default(static fn (Options $options, int|File|null $fileOrId) => $fileOrId ?? $options['id'])
            ->normalize($this->normalizeFile(...));

        return [
            ...$data,
            ...$resolver->resolve($data),
        ];
    }

    public function getUrl(): string
    {
        return $this->assetUrlGenerator->__invoke(
            $this->file,
            $this->download,
        );
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
