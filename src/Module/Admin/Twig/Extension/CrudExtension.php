<?php

declare(strict_types=1);

namespace App\Module\Admin\Twig\Extension;

use App\Module\Admin\Crud\CrudConfig;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigTest;

/** @template T of object */
class CrudExtension extends AbstractExtension
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /** @inheritDoc */
    public function getTests(): array
    {
        return [
            new TwigTest('crud_has_create', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getCreateRouteName())),
            new TwigTest('crud_has_edit', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getEditRouteName())),
            new TwigTest('crud_has_remove', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getRemoveRouteName())),
            new TwigTest('crud_has_up', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getUpRouteName())),
            new TwigTest('crud_has_down', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getDownRouteName())),
            new TwigTest('crud_has_enable', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getEnableRouteName())),
            new TwigTest('crud_has_disable', fn (CrudConfig $crudConfig): bool => $this->routeExists($crudConfig->getDisableRouteName())),
        ];
    }

    /** @inheritDoc */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('crud_url_list', $this->getListUrl(...)),
            new TwigFunction('crud_url_create', $this->getCreateUrl(...)),
            new TwigFunction('crud_url_edit', $this->getEditUrl(...)),
            new TwigFunction('crud_url_remove', $this->getRemoveUrl(...)),
            new TwigFunction('crud_url_up', $this->getUpUrl(...)),
            new TwigFunction('crud_url_down', $this->getDownUrl(...)),
            new TwigFunction('crud_url_enable', $this->getEnableUrl(...)),
            new TwigFunction('crud_url_disable', $this->getDisableUrl(...)),
        ];
    }

    /** @param CrudConfig<T> $crudConfig */
    private function getListUrl(CrudConfig $crudConfig): string
    {
        return $this->urlGenerator->generate($crudConfig->getListRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    private function getCreateUrl(CrudConfig $crudConfig): string
    {
        return $this->urlGenerator->generate($crudConfig->getCreateRouteName());
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getEditUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getEditRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getRemoveUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getRemoveRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getUpUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getUpRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getDownUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getDownRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getEnableUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getEnableRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    private function getDisableUrl(CrudConfig $crudConfig, object $object): string
    {
        return $this->urlGenerator->generate($crudConfig->getDisableRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     *
     * @return array<string, string|int>
     */
    private function getObjectParameters(CrudConfig $crudConfig, object $object): array
    {
        return [
            'object' => $crudConfig->getObjectIdentifier($object),
        ];
    }

    private function routeExists(string $routeName): bool
    {
        try {
            $this->urlGenerator->generate($routeName);
        } catch (RouteNotFoundException) {
            return false;
        } catch (Throwable) {
            return true;
        }

        return true;
    }
}
