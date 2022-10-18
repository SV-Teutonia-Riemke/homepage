<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

use DateTimeInterface;

interface ModifiedInterface
{
    public function setCreatedAt(DateTimeInterface $createdAt): void;

    public function getCreatedAt(): DateTimeInterface|null;

    public function setUpdatedAt(DateTimeInterface $updatedAt): void;

    public function getUpdatedAt(): DateTimeInterface|null;
}
