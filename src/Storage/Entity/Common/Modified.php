<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Shapecode\Doctrine\DBAL\Types\DateTimeUTCType;

trait Modified
{
    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: false)]
    protected ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: DateTimeUTCType::DATETIMEUTC, nullable: true)]
    protected ?DateTimeInterface $updatedAt = null;

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
}
