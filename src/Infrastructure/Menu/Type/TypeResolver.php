<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type;

use App\Infrastructure\Menu\MenuType;
use App\Infrastructure\Menu\Type\Resolver\ClubResolver;
use App\Infrastructure\Menu\Type\Resolver\DownloadsResolver;
use App\Infrastructure\Menu\Type\Resolver\ImprintResolver;
use App\Infrastructure\Menu\Type\Resolver\LinksResolver;
use App\Infrastructure\Menu\Type\Resolver\MainResolver;
use App\Infrastructure\Menu\Type\Resolver\NewsResolver;
use App\Infrastructure\Menu\Type\Resolver\PageResolver;
use App\Infrastructure\Menu\Type\Resolver\PrivacyResolver;
use App\Infrastructure\Menu\Type\Resolver\SimpleResolver;
use App\Infrastructure\Menu\Type\Resolver\SponsorResolver;
use App\Infrastructure\Menu\Type\Resolver\TeamsResolver;
use App\Storage\Entity\MenuItem;
use Knp\Menu\FactoryInterface;

class TypeResolver
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly ClubResolver $clubResolver,
        private readonly DownloadsResolver $downloadsResolver,
        private readonly ImprintResolver $imprintResolver,
        private readonly LinksResolver $linksResolver,
        private readonly MainResolver $mainResolver,
        private readonly NewsResolver $newsResolver,
        private readonly PageResolver $pageResolver,
        private readonly PrivacyResolver $privacyResolver,
        private readonly SimpleResolver $simpleResolver,
        private readonly SponsorResolver $sponsorResolver,
        private readonly TeamsResolver $teamsResolver,
    ) {
    }

    public function resolve(MenuItem $menuItem): object
    {
        $resolver = match ($menuItem->getType()) {
            MenuType::CLUB => fn () => $this->clubResolver,
            MenuType::DOWNLOADS => fn () => $this->downloadsResolver,
            MenuType::IMPRINT => fn () => $this->imprintResolver,
            MenuType::LINKS => fn () => $this->linksResolver,
            MenuType::MAIN => fn () => $this->mainResolver,
            MenuType::NEWS => fn () => $this->newsResolver,
            MenuType::PAGE => fn () => $this->pageResolver,
            MenuType::PRIVACY => fn () => $this->privacyResolver,
            MenuType::SIMPLE => fn () => $this->simpleResolver,
            MenuType::SPONSOR => fn () => $this->sponsorResolver,
            MenuType::TEAMS => fn () => $this->teamsResolver,
        };

        return $resolver()->__invoke($menuItem, $this->factory);
    }
}
