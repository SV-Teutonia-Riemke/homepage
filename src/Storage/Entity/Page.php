<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Storage\Repository\PageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page extends AbstractEntity
{
}
