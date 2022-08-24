<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824171027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert configs';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                INSERT INTO config_setting 
                    (name, type, value, created_at) 
                VALUES  
                    ('imprint', 'wysiwyg', null, UTC_TIMESTAMP),
                    ('privacy_polices', 'wysiwyg', null, UTC_TIMESTAMP),
                    ('copyright', 'wysiwyg', null, UTC_TIMESTAMP),
                    ('disclaimer', 'wysiwyg', null, UTC_TIMESTAMP);
            SQL
        );
    }
}
