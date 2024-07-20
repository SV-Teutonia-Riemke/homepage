<?php

declare(strict_types=1);

namespace App\Domain;

enum Role: string
{
    case ADMIN                = 'ROLE_ADMIN';
    case MANAGE_USERS         = 'ROLE_MANAGE_USERS';
    case MANAGE_ARTICLES      = 'ROLE_MANAGE_ARTICLES';
    case MANAGE_LINKS         = 'ROLE_MANAGE_LINKS';
    case MANAGE_DOWNLOADS     = 'ROLE_MANAGE_DOWNLOADS';
    case MANAGE_NOTIFICATIONS = 'ROLE_MANAGE_NOTIFICATIONS';
    case MANAGE_TEAMS         = 'ROLE_MANAGE_TEAMS';
    case MANAGE_PERSONS       = 'ROLE_MANAGE_PERSONS';
    case MANAGE_PERSON_GROUPS = 'ROLE_MANAGE_PERSON_GROUPS';
    case MANAGE_PAGES         = 'ROLE_MANAGE_PAGES';
    case MANAGE_MENU          = 'ROLE_MANAGE_MENU';
    case MANAGE_SHORT_URLS    = 'ROLE_MANAGE_SHORT_URLS';
    case MANAGE_SPONSORS      = 'ROLE_MANAGE_SPONSORS';
    case MANAGE_FILES         = 'ROLE_MANAGE_FILES';
    case MANAGE_SETTINGS      = 'ROLE_MANAGE_SETTINGS';
    case MANAGE_FAQ           = 'ROLE_MANAGE_FAQ';

    public function getTranslation(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::MANAGE_USERS => 'Benutzer verwalten',
            self::MANAGE_ARTICLES => 'Artikel verwalten',
            self::MANAGE_LINKS => 'Links verwalten',
            self::MANAGE_DOWNLOADS => 'Downloads verwalten',
            self::MANAGE_NOTIFICATIONS => 'Benachrichtigungen verwalten',
            self::MANAGE_TEAMS => 'Teams verwalten',
            self::MANAGE_PERSONS => 'Personen verwalten',
            self::MANAGE_PERSON_GROUPS => 'Personengruppen verwalten',
            self::MANAGE_PAGES => 'Seiten verwalten',
            self::MANAGE_MENU => 'Menüs verwalten',
            self::MANAGE_SHORT_URLS => 'Short URLs verwalten',
            self::MANAGE_SPONSORS => 'Sponsoren verwalten',
            self::MANAGE_FILES => 'Dateien verwalten',
            self::MANAGE_SETTINGS => 'Einstellungen verwalten',
            self::MANAGE_FAQ => 'FAQ verwalten',
        };
    }
}
