<?php

declare(strict_types=1);

namespace App\Twig\Components\File;

use App\Storage\Entity\File;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(
    name: 'lightbox',
    template: 'components/file/lightbox.htm.twig',
)]
class LightboxComponent
{
    public File $file;
    public string $lightbox = 'default';
}
