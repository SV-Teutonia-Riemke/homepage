<?php

declare(strict_types=1);

namespace App\Website\Domain;

enum ContactType: string
{
    case MEMBERSHIP           = 'membership';
    case MEMBERSHIP_UPDATE    = 'membership_update';
    case TEST_TRAINING_JUNIOR = 'test_training_junior';
    case TEST_TRAINING_SENIOR = 'test_training_senior';
    case CANCEL               = 'cancel';
    case SPONSORING           = 'sponsoring';
    case GENERAL              = 'general';

    public function getLabel(): string
    {
        return match ($this) {
            self::GENERAL => 'Allgemeine Anfrage',
            self::MEMBERSHIP => 'Fragen zur Mitgliedschaft',
            self::MEMBERSHIP_UPDATE => 'Daten der Mitgliedschaft ändern',
            self::CANCEL => 'Kündigen',
            self::SPONSORING => 'Sponsoring',
            self::TEST_TRAINING_JUNIOR => 'Probetraining Jugend',
            self::TEST_TRAINING_SENIOR => 'Probetraining Senioren',
        };
    }

    public function getSendTo(): string
    {
        return match ($this) {
            self::TEST_TRAINING_JUNIOR => 'jugend@teutonia-riemke.de',
            self::MEMBERSHIP,
            self::MEMBERSHIP_UPDATE,
            self::CANCEL => 'mitgliedschaft@teutonia-riemke.de',
            default => 'info@teutonia-riemke.de',
        };
    }
}
