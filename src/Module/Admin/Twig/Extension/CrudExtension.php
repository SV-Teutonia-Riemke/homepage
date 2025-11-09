<?php

declare(strict_types=1);

namespace App\Module\Admin\Twig\Extension;

use App\Module\Admin\Crud\CrudConfig;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;
use Twig\Attribute\AsTwigFunction;
use Twig\Attribute\AsTwigTest;

/** @template T of object */
class CrudExtension
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_create')]
    public function hasCreate(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getCreateRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_edit')]
    public function hasEdit(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getEditRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_remove')]
    public function hasRemove(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getRemoveRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_up')]
    public function hasUp(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getUpRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_down')]
    public function hasDown(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getDownRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_enable')]
    public function hasEnable(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getEnableRouteName());
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigTest('crud_has_disable')]
    public function hasDisable(CrudConfig $crudConfig): bool
    {
        return $this->routeExists($crudConfig->getDisableRouteName());
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

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigFunction('crud_url_list')]
    public function getListUrl(CrudConfig $crudConfig): string
    {
        return $this->urlGenerator->generate(
            $crudConfig->getListRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    /** @param CrudConfig<T> $crudConfig */
    #[AsTwigFunction('crud_url_create')]
    public function getCreateUrl(CrudConfig $crudConfig): string
    {
        return $this->urlGenerator->generate(
            $crudConfig->getCreateRouteName(),
            $crudConfig->getDefaultRouteParams(),
        );
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_edit')]
    public function getEditUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate(
            $crudConfig->getEditRouteName(),
            $this->getObjectParameters($crudConfig, $object),
        );
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_remove')]
    public function getRemoveUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate($crudConfig->getRemoveRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_up')]
    public function getUpUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate($crudConfig->getUpRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_down')]
    public function getDownUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate($crudConfig->getDownRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_enable')]
    public function getEnableUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate($crudConfig->getEnableRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     */
    #[AsTwigFunction('crud_url_disable')]
    public function getDisableUrl(
        CrudConfig $crudConfig,
        object $object,
    ): string {
        return $this->urlGenerator->generate($crudConfig->getDisableRouteName(), $this->getObjectParameters($crudConfig, $object));
    }

    /**
     * @param CrudConfig<T> $crudConfig
     * @param T             $object
     *
     * @return array<string, string|int>
     */
    private function getObjectParameters(
        CrudConfig $crudConfig,
        object $object,
    ): array {
        $objects = ['object' => $crudConfig->getObjectIdentifier($object)];

        return [
            ...$crudConfig->getDefaultRouteParams(),
            ...$objects,
        ];
    }
}
