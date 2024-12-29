<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Url;

use App\Infrastructure\ImgProxy\Domain\ImageFormat;
use App\Infrastructure\ImgProxy\Helper\Encoder;
use App\Infrastructure\ImgProxy\Options\Options;
use App\Infrastructure\ImgProxy\Signer\Signer;
use Stringable;

use function array_filter;
use function implode;
use function parse_url;
use function pathinfo;
use function sprintf;
use function str_replace;
use function wordwrap;

use const PATHINFO_EXTENSION;
use const PHP_URL_PATH;

final readonly class Url implements Stringable
{
    public function __construct(
        private string $baseUrl,
        private Signer $signer,
        private string $source,
        private Options $options,
        private ImageFormat|null $format,
        private bool $encoded,
        private bool $addExtension,
        private int $splitSize,
    ) {
    }

    private function encodedSource(): string
    {
        if ($this->encoded) {
            $sep    = '.';
            $source = Encoder::encode($this->source);

            if ($this->splitSize > 0) {
                $source = wordwrap($source, $this->splitSize, '/', true);
            }
        } else {
            $sep    = '@';
            $source = str_replace($sep, '%40', 'plain/' . $this->source);
        }

        $extension = $this->encoded && $this->format !== null ? $this->format->value : null;

        if ($extension === null && $this->addExtension) {
            $extension = $this->extension($this->source);
        }

        return implode(
            $sep,
            array_filter(
                [$source, $extension],
                static fn (string|null $part): bool => $part !== null,
            ),
        );
    }

    private function extension(string $src): string
    {
        $parsed = parse_url($src, PHP_URL_PATH);
        if ($parsed === false || $parsed === null) {
            return '';
        }

        return pathinfo($parsed, PATHINFO_EXTENSION);
    }

    public function __toString(): string
    {
        $path = sprintf(
            '/%s/%s',
            $this->options->getQueryPath(),
            $this->encodedSource(),
        );

        return sprintf(
            '%s/%s%s',
            $this->baseUrl,
            ($this->signer)($path),
            $path,
        );
    }
}
