<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy;

use App\Infrastructure\ImgProxy\Options\Padding;
use App\Infrastructure\ImgProxy\Options\Resize;
use App\Infrastructure\ImgProxy\Options\ResizingType;
use App\Infrastructure\ImgProxy\Preset\Preset;
use InvalidArgumentException;

use function sprintf;

class PresetManager
{
    /** @var array<string, Preset> */
    private array $presets = [];

    public function __construct()
    {
        $this->addDefaults();
    }

    public function add(
        string $name,
        Preset $preset,
    ): void {
        if ($this->has($name)) {
            throw new InvalidArgumentException(sprintf('Preset "%s" already exists.', $name));
        }

        $this->presets[$name] = $preset;
    }

    public function get(string $name): Preset
    {
        if (! $this->has($name)) {
            throw new InvalidArgumentException(sprintf('Preset "%s" not found.', $name));
        }

        return $this->presets[$name];
    }

    public function has(string $name): bool
    {
        return isset($this->presets[$name]);
    }

    private function addDefaults(): void
    {
        $resize = Resize::create(ResizingType::FIT)->enlarge()->extend();

        $this->add('sponsor_index', Preset::create(
            $resize->width(118)->height(60),
            Padding::all(2),
        ));

        $this->add('sponsor_index_main', Preset::create(
            $resize->width(260)->height(130),
            Padding::all(2),
        ));

        $this->add('sponsor_main', Preset::create(
            $resize->width(420)->height(220),
            Padding::xy(20, 15),
        ));

        $this->add('sponsor_page', Preset::create(
            $resize->width(260)->height(130),
            Padding::xy(10, 10),
        ));
    }
}
