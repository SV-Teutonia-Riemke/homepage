<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

interface EnabledInterface
{
    public function isEnabled(): bool;

    public function setEnabled(bool $enabled): void;
}
