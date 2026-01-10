<?php

declare(strict_types=1);

namespace App;

use Override;
use ReflectionObject;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Webmozart\Assert\Assert;

use function array_filter;
use function array_map;
use function array_merge;
use function error_reporting;
use function is_file;
use function sprintf;

use const E_ALL;
use const E_DEPRECATED;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(
        string $environment,
        bool $debug,
        private string|null $id = null,
    ) {
        parent::__construct($environment, $debug);
    }

    #[Override]
    public function boot(): void
    {
        parent::boot();

        error_reporting(E_ALL & ~E_DEPRECATED);
    }

    public function getSharedConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    private function hasAppConfig(): bool
    {
        return $this->id !== null;
    }

    public function getAppConfigDir(): string
    {
        if (! $this->hasAppConfig()) {
            throw new RuntimeException('Application config directory is not defined');
        }

        return $this->getProjectDir() . '/apps/' . $this->id . '/config';
    }

    /** @inheritDoc */
    public function registerBundles(): iterable
    {
        $bundlesPath = [
            sprintf('%s/bundles.php', $this->getSharedConfigDir()),
        ];

        if ($this->hasAppConfig()) {
            $bundlesPath[] = sprintf('%s/bundles.php', $this->getAppConfigDir());
        }

        $bundlesPath = array_filter(
            $bundlesPath,
            is_file(...),
        );

        $bundles = array_merge(...array_map(
            static fn (string $path): array => require $path,
            $bundlesPath,
        ));

        foreach ($bundles as $class => $envs) {
            if (! ($envs[$this->environment] ?? $envs['all'] ?? false)) {
                continue;
            }

            Assert::subclassOf($class, BundleInterface::class);

            yield new $class();
        }
    }

    #[Override]
    public function getCacheDir(): string
    {
        $cacheDir = $_SERVER['APP_CACHE_DIR'] ?? null;
        if ($cacheDir !== null) {
            return $cacheDir;
        }

        if ($this->hasAppConfig()) {
            return sprintf('%s/var/cache/%s/%s', $this->getProjectDir(), $this->id, $this->environment);
        }

        return parent::getCacheDir();
    }

    #[Override]
    public function getLogDir(): string
    {
        $logDir = $_SERVER['APP_LOG_DIR'] ?? null;
        if ($logDir !== null) {
            return $logDir;
        }

        if ($this->hasAppConfig()) {
            return sprintf('%s/var/log/%s', $this->getProjectDir(), $this->id);
        }

        return parent::getLogDir();
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $this->doConfigureContainer($container, $this->getSharedConfigDir());

        if (! $this->hasAppConfig()) {
            return;
        }

        $this->doConfigureContainer($container, $this->getAppConfigDir());
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->doConfigureRoutes($routes, $this->getSharedConfigDir());

        if (! $this->hasAppConfig()) {
            return;
        }

        $this->doConfigureRoutes($routes, $this->getAppConfigDir());
    }

    private function doConfigureContainer(
        ContainerConfigurator $container,
        string $configDir,
    ): void {
        $container->import($configDir . '/{packages}/*.{php,yaml}');
        $container->import($configDir . '/{packages}/' . $this->environment . '/*.{php,yaml}');

        if (is_file($configDir . '/services.yaml')) {
            $container->import($configDir . '/services.yaml');
            $container->import($configDir . '/{services}_' . $this->environment . '.yaml');
        } else {
            $container->import($configDir . '/{services}.php');
        }
    }

    private function doConfigureRoutes(
        RoutingConfigurator $routes,
        string $configDir,
    ): void {
        $routes->import($configDir . '/{routes}/' . $this->environment . '/*.{php,yaml}');
        $routes->import($configDir . '/{routes}/*.{php,yaml}');

        if (is_file($configDir . '/routes.yaml')) {
            $routes->import($configDir . '/routes.yaml');
        } else {
            $routes->import($configDir . '/{routes}.php');
        }

        $fileName = new ReflectionObject($this)->getFileName();
        if ($fileName === false) {
            return;
        }

        $routes->import($fileName, 'attribute');
    }
}
