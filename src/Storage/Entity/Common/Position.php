<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait Position
{
    #[Gedmo\SortablePosition]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private int|null $position = null;

    public function getPosition(): int|null
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        if ($position < 0) {
            $position = 0;
        }

        $this->position = $position;
    }

    public function increasePosition(int $position): void
    {
        $this->setPosition(($this->getPosition() ?? 0) + $position);
    }
}
