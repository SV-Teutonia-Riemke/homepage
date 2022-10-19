<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221019181324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE team 
                    ADD season VARCHAR(255) DEFAULT NULL COMMENT '(DC2Type:year_group)' AFTER gender,
                    ADD age_group VARCHAR(255) DEFAULT NULL COMMENT '(DC2Type:year_group)' AFTER season 
            SQL,
        );
    }
}
