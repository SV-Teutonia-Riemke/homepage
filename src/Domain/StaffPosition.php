<?php

declare(strict_types=1);

namespace App\Domain;

use Symfony\Component\Translation\TranslatableMessage;

use function sprintf;

enum StaffPosition: string
{
    case TRAINER            = 'trainer';
    case CO_TRAINER         = 'co_trainer';
    case GOALKEEPER_TRAINER = 'goalkeepr_trainer';
    case TEAM_RESPONSIBLE   = 'team_responsible';

    public function getTranslatable(): TranslatableMessage
    {
        return new TranslatableMessage(
            sprintf('staff_position_%s', $this->value),
        );
    }
}
