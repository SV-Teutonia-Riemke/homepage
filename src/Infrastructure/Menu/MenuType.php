<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu;

enum MenuType: string
{
    case CLUB      = 'club';
    case DOWNLOADS = 'downloads';
    case IMPRINT   = 'imprint';
    case LINKS     = 'links';
    case PAGE      = 'page';
    case MAIN      = 'main';
    case NEWS      = 'news';
    case PRIVACY   = 'privacy';
    case URL       = 'url';
    case SPONSOR   = 'sponsor';
    case TEAMS     = 'teams';
    case FAQ       = 'faq';
    case CONTACT   = 'contact';
}
