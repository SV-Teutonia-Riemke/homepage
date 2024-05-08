<?php

declare(strict_types=1);

namespace App\Storage\Entity\MenuItem;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\MenuItem;
use App\Storage\Entity\Page;
use App\Storage\Repository\MenuItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuItemRepository::class)]
class MenuItemPage extends MenuItem
{
    #[ORM\ManyToOne(targetEntity: Page::class)]
    private Page $page;

    public function __construct(
        string $title,
        string $icon,
        Page $page,
        MenuType $type,
        MenuGroup $group,
    ) {
        parent::__construct($title, $icon, $type, $group);

        $this->page = $page;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $page): void
    {
        $this->page = $page;
    }
}
