<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Options;

use App\Infrastructure\ImgProxy\Support\GravityType;
use InvalidArgumentException;

use function explode;
use function is_numeric;
use function sprintf;

final class Gravity extends AbstractOption
{
    public readonly GravityType $type;

    public function __construct(
        string $type,
        private float|null $x = null,
        private float|null $y = null,
    ) {
        $this->type = new GravityType($type);

        if ($x < 0) {
            throw new InvalidArgumentException(sprintf('Invalid gravity X: %s', $x));
        }

        if ($y < 0) {
            throw new InvalidArgumentException(sprintf('Invalid gravity Y: %s', $y));
        }
    }

    /** @return static */
    public static function fromString(string $gravity): self
    {
        $params = explode(':', $gravity, 3);

        if (isset($params[1]) && ! is_numeric($params[1])) {
            throw new InvalidArgumentException('Gravity X should be numeric');
        }

        if (isset($params[2]) && ! is_numeric($params[2])) {
            throw new InvalidArgumentException('Gravity Y should be numeric');
        }

        return new self(
            $params[0],
            isset($params[1]) ? (float) $params[1] : null,
            isset($params[2]) ? (float) $params[2] : null,
        );
    }

    public static function name(): string
    {
        return 'g';
    }

    /** @inheritDoc */
    public function data(): array
    {
        return [
            $this->type->value(),
            $this->x,
            $this->y,
        ];
    }
}
