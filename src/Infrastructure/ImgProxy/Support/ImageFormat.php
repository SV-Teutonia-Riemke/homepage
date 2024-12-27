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
        $this->extension = $this->cast($extension);

        if (! self::isSupported($this->extension)) {
            throw new InvalidArgumentException(sprintf('Invalid image format: %s', $extension));
        }
    }

    public static function isSupported(string $value): bool
    {
        return in_array($value, self::SUPPORTED);
    }

    public function isEquals(self $extension): bool
    {
        return $this->extension === $extension->extension;
    }

    public function value(): string
    {
        return $this->extension;
    }

    private function cast(string $extension): string
    {
        return strtolower(trim($extension));
    }
}
