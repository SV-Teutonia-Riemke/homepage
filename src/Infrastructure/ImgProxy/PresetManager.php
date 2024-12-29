<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy;

use App\Infrastructure\ImgProxy\Domain\Preset;
use App\Infrastructure\ImgProxy\Options\Builder\ResizeBuilder;
use App\Infrastructure\ImgProxy\Options\Padding;
use App\Infrastructure\ImgProxy\Options\Quality;
use App\Infrastructure\ImgProxy\Options\ResizingType;
use App\Infrastructure\ImgProxy\Options\Width;
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
        Preset $preset,
    ): void {
        if ($this->has($preset->name)) {
            throw new InvalidArgumentException(sprintf('Preset "%s" already exists.', $preset->name));
        }

        $this->presets[$preset->name] = $preset;
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
        $resize = ResizeBuilder::create(ResizingType::FIT)->enlarge()->extend();

        $this->add(Preset::create(
            'optimized',
            new Quality(80),
        ));

        $this->add(Preset::create(
            'sponsor_index',
            new Quality(80),
            $resize->width(118)->height(60),
            Padding::all(2),
        ));

        $this->add(Preset::create(
            'sponsor_index_main',
            new Quality(80),
            $resize->width(260)->height(130),
            Padding::all(2),
        ));

        $this->add(Preset::create(
            'sponsor_main',
            new Quality(80),
            $resize->width(420)->height(220),
            Padding::xy(20, 15),
        ));

        $this->add(Preset::create(
            'sponsor_page',
            new Quality(80),
            $resize->width(260)->height(130),
            Padding::xy(10, 10),
        ));

        $this->add(Preset::create(
            'login_cover',
            new Quality(75),
            new Width(1280),
        ));

        $this->add(Preset::create(
            'team_player_portrait',
            new Quality(75),
            new Width(400),
        ));

        $this->add(Preset::create(
            'person_portrait',
            new Quality(75),
            new Width(160),
        ));
    }
}
