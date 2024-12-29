<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use ArrayIterator;
use Countable;
use IteratorAggregate;

use function array_map;
use function array_merge;
use function array_values;
use function count;
use function implode;

/** @implements IteratorAggregate<int, Option> */
final class Options implements IteratorAggregate, Countable
{
    /** @var list<Option> */
    private array $options;

    public function __construct(Option ...$options)
    {
        $this->options = array_values($options);
    }

    /** @return ArrayIterator<int, Option> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->options);
    }

    public function merge(self $options): self
    {
        return new self(...array_merge($this->options, $options->options));
    }

    public function add(Option ...$options): self
    {
        return new self(...array_merge($this->options, $options));
    }

    public function getQueryPath(): string
    {
        $optionsAsString = array_map(
            static fn (Option $option): string => $option->__toString(),
            $this->options,
        );

        return implode('/', $optionsAsString);
    }

    public function count(): int
    {
        return count($this->options);
    }
}
