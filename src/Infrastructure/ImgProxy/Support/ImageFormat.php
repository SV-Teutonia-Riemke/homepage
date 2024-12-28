<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Support;

use InvalidArgumentException;

use function in_array;
use function sprintf;
use function strtolower;
use function trim;

class ImageFormat
{
    private const SUPPORTED = [
        'png',
        'jpg',
        'jpeg',
        'webp',
        'avif',
        'gif',
        'ico',
        'svg',
        'heic',
        'bmp',
        'tiff',
        'pdf',
        'mp4',
    ];

    private string $extension;

    public function __construct(string $extension)
    {
        $this->extension = strtolower(trim($extension));

        if (! in_array($extension, self::SUPPORTED, true)) {
            throw new InvalidArgumentException(sprintf('Invalid image format: %s', $extension));
        }
    }

    public function value(): string
    {
        return $this->extension;
    }
}
