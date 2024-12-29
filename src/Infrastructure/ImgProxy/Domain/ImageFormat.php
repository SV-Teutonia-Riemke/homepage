<?php

declare(strict_types=1);

namespace App\Infrastructure\ImgProxy\Domain;

enum ImageFormat: string
{
    case PNG  = 'png';
    case JPG  = 'jpg';
    case JPEG = 'jpeg';
    case WEBP = 'webp';
    case AVIF = 'avif';
    case GIF  = 'gif';
    case ICO  = 'ico';
    case SVG  = 'svg';
    case HEIC = 'heic';
    case BMP  = 'bmp';
    case TIFF = 'tiff';
    case PDF  = 'pdf';
    case MP4  = 'mp4';
}
