<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use ArrayIterator;
use IteratorAggregate;

/** @template-implements IteratorAggregate<int, ConfigTree> */
final class ConfigTreeCollection implements IteratorAggregate
{
    /** @var list<ConfigTree> */
    private array $items = [];

    public function add(ConfigTree $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function getAllItems(): ConfigItemCollection
    {
        $collection = new ConfigItemCollection();

        foreach ($this->items as $configTree) {
            $collection = $collection->merge($configTree->getAllItems());
        }

        return $collection;
    }

    /** @return ArrayIterator<int, ConfigTree> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }
}
