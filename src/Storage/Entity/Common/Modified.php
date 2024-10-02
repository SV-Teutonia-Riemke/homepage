<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

trait Modified
{
    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: false)]
    protected DateTimeInterface|null $createdAt = null;

    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: true)]
    protected DateTimeInterface|null $updatedAt = null;

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        if ($this->createdAt === null) {
            throw new RuntimeException('The created at date is not set yet.');
        }

        return $this->createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): DateTimeInterface|null
    {
        return $this->updatedAt;
    }
}
