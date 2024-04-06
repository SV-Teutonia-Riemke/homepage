<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Generator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

use function sprintf;
use function str_replace;

class GlobExtension extends AbstractExtension
{
    public function __construct(
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,
    ) {
    }

    /** @inheritDoc */
    public function getFilters(): array
    {
        $publicDir = $this->projectDir . '/public';

        return [
            new TwigFilter('glob', static function ($directory, $pattern = '*') use ($publicDir): Generator {
                $directory = str_replace('/', '\/', $directory);
                $directory = sprintf('%s%s%s', '/', $directory, '/');

                $finder = new Finder();
                $finder->files()
                    ->in($publicDir)
                    ->path($directory)
                    ->name($pattern);

                foreach ($finder as $item) {
                    yield $item;
                }
            }),
        ];
    }
}
