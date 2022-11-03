<?php

declare(strict_types=1);

namespace App\Infrastructure\Config;

use Symfony\Component\Translation\TranslatableMessage;

use function iterator_to_array;
use function sprintf;

final class ConfigTree
{
    private self|null $parent;

    private int $level = 0;

    private readonly ConfigTreeCollection $children;

    private readonly ConfigItemCollection $items;

    public function __construct(private readonly string $name)
    {
        $this->children = new ConfigTreeCollection();
        $this->items    = new ConfigItemCollection();
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): TranslatableMessage
    {
        return new TranslatableMessage(sprintf('category_%s', $this->name), [], 'config');
    }

    public function getParent(): ConfigTree|null
    {
        return $this->parent;
    }

    public function setParent(ConfigTree $parent): void
    {
        $this->parent = $parent;
        $this->level  = $parent->level + 1;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getChildren(): ConfigTreeCollection
    {
        return $this->children;
    }

    public function getItems(): ConfigItemCollection
    {
        return $this->items;
    }

    public function getAllItems(): ConfigItemCollection
    {
        $merged = new ConfigItemCollection(...iterator_to_array($this->items));

        foreach ($this->children as $child) {
            $merged = $merged->merge($child->getAllItems());
        }

        return $merged;
    }

    public function addChild(string $name): self
    {
        $child = new ConfigTree($name);
        $child->setParent($this);

        $this->children->add($child);

        return $child;
    }

    public function addItem(ConfigItem ...$items): self
    {
        foreach ($items as $item) {
            $this->items->add($item);
        }

        return $this;
    }
}
