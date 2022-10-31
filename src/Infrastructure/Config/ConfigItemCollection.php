<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use ArrayIterator;
use IteratorAggregate;

use function array_merge;
use function array_values;

/** @template-implements IteratorAggregate<int, ConfigItem> */
final class ConfigItemCollection implements IteratorAggregate
{
    /** @var list<ConfigItem> */
    private array $items;

    public function __construct(ConfigItem ...$items)
    {
        $this->items = array_values($items);
    }

    public function add(ConfigItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /** @return ArrayIterator<int, ConfigItem> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function merge(self $collection): self
    {
        return new self(
            ...array_merge($this->items, $collection->items),
        );
    }
}
