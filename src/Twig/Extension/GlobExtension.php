<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Generator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Finder\Finder;
use Twig\Attribute\AsTwigFilter;

use function sprintf;
use function str_replace;

final readonly class GlobExtension
{
    public function __construct(
        #[Autowire(param: 'kernel.project_dir')]
        private string $projectDir,
    ) {
    }

    #[AsTwigFilter('glob')]
    public function globs(
        string $directory,
        string $pattern = '*',
    ): Generator {
        $publicDir = $this->projectDir . '/public';

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
    }
}
