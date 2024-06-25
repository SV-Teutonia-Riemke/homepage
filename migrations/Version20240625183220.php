<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625183220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE faq_category (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    title VARCHAR(255) NOT NULL, 
                    enabled TINYINT(1) DEFAULT 1 NOT NULL, 
                    position INT DEFAULT NULL, 
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                CREATE TABLE faq_article (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    group_id INT UNSIGNED NOT NULL, 
                    title VARCHAR(255) NOT NULL, 
                    content LONGTEXT NOT NULL, 
                    enabled TINYINT(1) DEFAULT 1 NOT NULL,
                    position INT DEFAULT NULL, 
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)', 
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)', 
                    INDEX IDX_194B653DFE54D947 (group_id),
                    CONSTRAINT FK_194B653DFE54D947 FOREIGN KEY (group_id) REFERENCES faq_category (id) ON DELETE CASCADE,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );
    }
}
