<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

interface PositionInterface
{
    public function getPosition(): int|null;

    public function setPosition(int $position): void;

    public function increasePosition(int $position): void;
}
