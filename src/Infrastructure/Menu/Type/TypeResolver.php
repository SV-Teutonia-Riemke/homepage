<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu\Type;

use App\Infrastructure\Menu\MenuType;
use App\Infrastructure\Menu\Type\Resolver\ClubResolver;
use App\Infrastructure\Menu\Type\Resolver\ContactResolver;
use App\Infrastructure\Menu\Type\Resolver\DownloadsResolver;
use App\Infrastructure\Menu\Type\Resolver\FaqResolver;
use App\Infrastructure\Menu\Type\Resolver\ImprintResolver;
use App\Infrastructure\Menu\Type\Resolver\LinksResolver;
use App\Infrastructure\Menu\Type\Resolver\MainResolver;
use App\Infrastructure\Menu\Type\Resolver\NewsResolver;
use App\Infrastructure\Menu\Type\Resolver\PageResolver;
use App\Infrastructure\Menu\Type\Resolver\PrivacyResolver;
use App\Infrastructure\Menu\Type\Resolver\SponsorResolver;
use App\Infrastructure\Menu\Type\Resolver\TeamsResolver;
use App\Infrastructure\Menu\Type\Resolver\UrlResolver;
use App\Storage\Entity\MenuItem;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class TypeResolver
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly ClubResolver $clubResolver,
        private readonly ContactResolver $contact,
        private readonly DownloadsResolver $downloadsResolver,
        private readonly FaqResolver $faqResolver,
        private readonly ImprintResolver $imprintResolver,
        private readonly LinksResolver $linksResolver,
        private readonly MainResolver $mainResolver,
        private readonly NewsResolver $newsResolver,
        private readonly PageResolver $pageResolver,
        private readonly PrivacyResolver $privacyResolver,
        private readonly UrlResolver $urlResolver,
        private readonly SponsorResolver $sponsorResolver,
        private readonly TeamsResolver $teamsResolver,
    ) {
    }

    public function resolve(MenuItem $menuItem): ItemInterface
    {
        $resolver = match ($menuItem->getType()) {
            MenuType::CLUB => fn (): ClubResolver => $this->clubResolver,
            MenuType::CONTACT => fn (): ContactResolver => $this->contact,
            MenuType::DOWNLOADS => fn (): DownloadsResolver => $this->downloadsResolver,
            MenuType::FAQ => fn (): FaqResolver => $this->faqResolver,
            MenuType::IMPRINT => fn (): ImprintResolver => $this->imprintResolver,
            MenuType::LINKS => fn (): LinksResolver => $this->linksResolver,
            MenuType::MAIN => fn (): MainResolver => $this->mainResolver,
            MenuType::NEWS => fn (): NewsResolver => $this->newsResolver,
            MenuType::PAGE => fn (): PageResolver => $this->pageResolver,
            MenuType::PRIVACY => fn (): PrivacyResolver => $this->privacyResolver,
            MenuType::URL => fn (): UrlResolver => $this->urlResolver,
            MenuType::SPONSOR => fn (): SponsorResolver => $this->sponsorResolver,
            MenuType::TEAMS => fn (): TeamsResolver => $this->teamsResolver,
        };

        return $resolver()->__invoke($menuItem, $this->factory);
    }
}
