<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508183914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            <<<'SQL'
                CREATE TABLE menu_item (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    title VARCHAR(255) NOT NULL, 
                    icon VARCHAR(255) NOT NULL, 
                    type VARCHAR(255) NOT NULL, 
                    `group` VARCHAR(255) NOT NULL, 
                    enabled TINYINT(1) DEFAULT 1 NOT NULL, 
                    position INT NOT NULL,
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );
    }
}
