<?php

declare(strict_types=1);

namespace App\Infrastructure\Menu;

enum MenuGroup: string
{
    case MAIN         = 'main';
    case LEGAL        = 'legal';
    case SOCIAL_MEDIA = 'social_media';
}
