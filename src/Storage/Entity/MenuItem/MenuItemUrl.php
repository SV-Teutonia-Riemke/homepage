<?php

declare(strict_types=1);

namespace App\Storage\Entity\MenuItem;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\MenuItem;
use App\Storage\Repository\MenuItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuItemRepository::class)]
class MenuItemUrl extends MenuItem
{
    #[ORM\Column(type: Types::STRING)]
    private string $url;

    public function __construct(
        string $title,
        string $icon,
        string $url,
        MenuGroup $group,
    ) {
        parent::__construct(
            $title,
            $icon,
            MenuType::URL,
            $group,
        );

        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string|null $url): void
    {
        if ($url === null) {
            return;
        }

        $this->url = $url;
    }
}
