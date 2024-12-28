<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy;

use App\Infrastructure\ImgProxy\Options\AbstractOption;
use App\Infrastructure\ImgProxy\Preset\Preset;
use App\Infrastructure\ImgProxy\Signer\Signer;
use App\Infrastructure\ImgProxy\Support\Encoder;
use App\Infrastructure\ImgProxy\Support\ImageFormat;
use Stringable;

use function array_filter;
use function array_merge;
use function implode;
use function sprintf;
use function str_replace;
use function wordwrap;

final class UrlBuilder implements Stringable
{
    private bool $encoded = true;

    private int $splitSize = 0;

    private Preset|null $preset = null;

    /** @var array<AbstractOption> */
    private array $options = [];

    private readonly ImageFormat|null $format;

    public function __construct(
        private readonly string $baseUrl,
        private readonly Signer $signer,
        private readonly string $source,
        string|null $extension = null,
    ) {
        $this->format = $extension !== null ? new ImageFormat($extension) : null;
    }

    public function with(AbstractOption ...$options): self
    {
        $self          = clone $this;
        $self->options = array_merge($this->options, $options);

        return $self;
    }

    public function withPreset(Preset $preset): self
    {
        $self         = clone $this;
        $self->preset = $preset;

        return $self;
    }

    public function encoded(bool $encoded): self
    {
        $self          = clone $this;
        $self->encoded = $encoded;

        return $self;
    }

    public function split(int $size): self
    {
        $self            = clone $this;
        $self->splitSize = $size;

        return $self;
    }

    public function __toString(): string
    {
        $options = $this->preset?->options ?? [];
        $options = array_merge($options, $this->options);

        $options = implode('/', $options);
        $path    = sprintf(
            '/%s/%s',
            $options,
            $this->source(),
        );

        return sprintf(
            '%s/%s%s',
            $this->baseUrl,
            $this->signer->__invoke($path),
            $path,
        );
    }

    private function source(): string
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

        $extension = $this->encoded && $this->format !== null ? $this->format->value() : null;

        return implode(
            $sep,
            array_filter(
                [$source, $extension],
                static fn (string|null $part): bool => $part !== null,
            ),
        );
    }
}
