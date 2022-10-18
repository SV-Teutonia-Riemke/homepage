<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

interface IdInterface
{
    public function getId(): int|null;
}
