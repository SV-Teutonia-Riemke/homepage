<?php

declare(strict_types=1);

namespace App\Storage\Entity;

use App\Infrastructure\Menu\MenuGroup;
use App\Infrastructure\Menu\MenuType;
use App\Storage\Entity\Common\Enabled;
use App\Storage\Entity\Common\EnabledInterface;
use App\Storage\Entity\Common\Position;
use App\Storage\Entity\Common\PositionInterface;
use App\Storage\Entity\MenuItem\MenuItemPage;
use App\Storage\Entity\MenuItem\MenuItemUrl;
use App\Storage\Repository\MenuItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
#[ORM\Entity(repositoryClass: MenuItemRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name: 'discriminator')]
#[ORM\DiscriminatorMap([
    'menu' => MenuItem::class,
    'page' => MenuItemPage::class,
    'url' => MenuItemUrl::class,
])]
class MenuItem extends AbstractEntity implements EnabledInterface, PositionInterface
{
    use Enabled;
    use Position;

    public function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $title,
        #[ORM\Column(type: Types::STRING)]
        private string $icon,
        #[ORM\Column(type: Types::STRING, enumType: MenuType::class)]
        private MenuType $type,
        #[ORM\Column(name: '`group`', type: Types::STRING, enumType: MenuGroup::class)]
        private MenuGroup $group,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    public function getType(): MenuType
    {
        return $this->type;
    }

    public function setType(MenuType $type): void
    {
        $this->type = $type;
    }

    public function getGroup(): MenuGroup
    {
        return $this->group;
    }

    public function setGroup(MenuGroup $group): void
    {
        $this->group = $group;
    }
}
