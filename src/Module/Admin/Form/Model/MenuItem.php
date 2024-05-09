<?php

declare(strict_types=1);

namespace App\Module\Admin\Form\Model;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\Page;

class MenuItem
{
    public string|null $title    = null;
    public string|null $icon     = null;
    public string|null $url      = null;
    public bool $enabled         = true;
    public Page|null $page       = null;
    public MenuType|null $type   = null;
    public MenuGroup|null $group = null;
}
