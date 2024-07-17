<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Entity\Common\EntityInterface;
use App\Storage\Entity\Common\Id;
use App\Storage\Entity\Common\Modified;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractEntity implements EntityInterface
{
    use Id;
    use Modified;
}
