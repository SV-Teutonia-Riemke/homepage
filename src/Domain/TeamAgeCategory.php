<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

enum TeamAgeCategory: string
{
    case JUNIOR = 'junior';
    case SENIOR = 'senior';

    public function getTranslatable(): TranslatableMessage
    {
        return new TranslatableMessage(
            sprintf('age_category_%s', $this->value),
        );
    }
}
