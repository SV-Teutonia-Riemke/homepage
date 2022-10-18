<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Extension;

use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;

use function array_merge;

final class OrderExtension implements ExtensionInterface
{
    public const KEY_NAME = 'order';

    /** @inheritDoc */
    public function buildOptions(array $options): array
    {
        return array_merge(
            [
                self::KEY_NAME => 0,
            ],
            $options,
        );
    }

    /** @inheritDoc */
    public function buildItem(ItemInterface $item, array $options): void
    {
        $item->setExtra(self::KEY_NAME, $options[self::KEY_NAME] ?? 0);
    }
}
