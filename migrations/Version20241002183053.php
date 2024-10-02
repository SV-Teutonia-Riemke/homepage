<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002183053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE external_article (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL,
                    url VARCHAR(255) NOT NULL,
                    title VARCHAR(255) NOT NULL,
                    description VARCHAR(255) DEFAULT NULL,
                    image_url VARCHAR(255) DEFAULT NULL,
                    author_name VARCHAR(255) DEFAULT NULL,
                    author_url VARCHAR(255) DEFAULT NULL,
                    published_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)',
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime)',
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)',
                    enabled TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)
                    ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );
    }
}
