<?php

declare(strict_types=1);

namespace App\Infrastructure\DependencyInjection;

abstract class AbstractConfigurator
{
    final protected function isTest(string $env): bool
    {
        return $env === 'test';
    }

    final protected function isProduction(string $env): bool
    {
        return $env === 'prod';
    }
}
