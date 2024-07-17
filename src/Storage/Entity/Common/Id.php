<?php

declare(strict_types=1);

namespace App\Storage\Entity\Common;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait Id
{
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected int|null $id = null;

    public function getId(): int|null
    {
        return $this->id;
    }
}
