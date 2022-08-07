<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Event;

use Knp\Menu\ItemInterface;
use Symfony\Contracts\EventDispatcher\Event;

use function in_array;

final class ConfigureMenuEvent extends Event
{
    public function __construct(
        private readonly ItemInterface $menuItem
    ) {
    }

    public function isNonOf(string ...$names): bool
    {
        return ! in_array($this->menuItem->getName(), $names, true);
    }

    public function getMenuItem(): ItemInterface
    {
        return $this->menuItem;
    }
}
