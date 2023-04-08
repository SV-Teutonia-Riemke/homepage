<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408124738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add downloads table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE download (
                    id INT UNSIGNED AUTO_INCREMENT NOT NULL, 
                    file_id INT UNSIGNED DEFAULT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    uri VARCHAR(255) DEFAULT NULL, 
                    enabled TINYINT(1) DEFAULT 1 NOT NULL, 
                    created_at DATETIME NOT NULL COMMENT '(DC2Type:datetimeutc)', 
                    updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetimeutc)', 
                    position INT NOT NULL, 
                    UNIQUE INDEX UNIQ_781A827093CB796C (file_id),
                    CONSTRAINT FK_781A827093CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE, 
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
            SQL,
        );
    }
}
