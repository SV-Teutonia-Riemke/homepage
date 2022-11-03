<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use ArrayIterator;
use IteratorAggregate;
use OutOfRangeException;

use function array_key_exists;
use function array_merge;
use function sprintf;

/** @template-implements IteratorAggregate<string, ConfigItem> */
final class ConfigItemCollection implements IteratorAggregate
{
    /** @var array<string, ConfigItem> */
    private array $items = [];

    public function __construct(ConfigItem ...$items)
    {
        $this->add(...$items);
    }

    public function add(ConfigItem ...$items): self
    {
        foreach ($items as $item) {
            $this->items[$item->name] = $item;
        }

        return $this;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->items);
    }

    public function get(string $name): ConfigItem
    {
        if (! $this->has($name)) {
            throw new OutOfRangeException(sprintf('item with name "%s" does not exist', $name), 1667508373649);
        }

        return $this->items[$name];
    }

    /** @return ArrayIterator<string, ConfigItem> */
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
