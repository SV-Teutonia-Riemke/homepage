<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030202407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE link 
                (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    uri VARCHAR(255) NOT NULL,
                    enabled TINYINT(1) DEFAULT 1 NOT NULL,
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetimeutc)', 
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );
    }
}
