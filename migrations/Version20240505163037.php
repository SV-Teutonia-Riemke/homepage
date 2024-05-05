<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505163037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE page 
                    ADD title VARCHAR(255) NOT NULL AFTER id, 
                    ADD content LONGTEXT NOT NULL AFTER title, 
                    ADD enabled TINYINT(1) DEFAULT 1 NOT NULL AFTER content
            SQL
        );
    }
}
