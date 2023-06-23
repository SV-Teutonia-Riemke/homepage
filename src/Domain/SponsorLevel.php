<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

enum SponsorLevel: string
{
    case MAIN        = 'main';
    case EXCLUSIVE   = 'exclusive';
    case PREMIUM     = 'premium';
    case SPONSOR     = 'sponsor';
    case KOOPERATION = 'kooperation';

    public function getTranslatable(): TranslatableMessage
    {
        return new TranslatableMessage(
            sprintf('sponsor_level_%s', $this->value),
        );
    }

    public function isMain(): bool
    {
        return $this === self::MAIN;
    }

    public function order(): int
    {
        return match ($this) {
            self::MAIN => 1,
            self::EXCLUSIVE => 2,
            self::PREMIUM => 3,
            self::SPONSOR => 4,
            self::KOOPERATION => 5,
        };
    }
}
