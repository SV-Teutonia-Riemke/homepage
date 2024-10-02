<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241002163134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE article
                    ADD author_id INT UNSIGNED DEFAULT NULL AFTER image_id,
                    ADD published_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime)' AFTER enabled,
                    ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES person (id) ON DELETE SET NULL,
                    ADD UNIQUE INDEX UNIQ_23A0E66F675F31B (author_id);
            SQL,
        );
    }
}
