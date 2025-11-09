<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Extension;

use App\Infrastructure\Menu\Event\ConfigureMenuEvent;
use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class EventDispatcherExtension implements ExtensionInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /** @inheritDoc */
    public function buildItem(
        ItemInterface $item,
        array $options,
    ): void {
        $this->eventDispatcher->dispatch(
            new ConfigureMenuEvent($item),
        );
    }

    /** @inheritDoc */
    public function buildOptions(array $options): array
    {
        return $options;
    }
}
