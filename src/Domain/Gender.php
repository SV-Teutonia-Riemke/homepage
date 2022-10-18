<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

enum Gender: string
{
    case MIXED  = 'mixed';
    case MALE   = 'male';
    case FEMALE = 'female';

    public function getTranslatable(): TranslatableMessage
    {
        return new TranslatableMessage(
            sprintf('gender_%s', $this->value),
        );
    }
}
