<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508193639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                CREATE TABLE menu_item_page (
                    id INT UNSIGNED NOT NULL, 
                    page_id INT UNSIGNED NOT NULL, 
                    INDEX IDX_C57A95EFC4663E4 (page_id),
                    CONSTRAINT FK_C57A95EFC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE,
                    CONSTRAINT FK_C57A95EFBF396750 FOREIGN KEY (id) REFERENCES menu_item (id) ON DELETE CASCADE,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                CREATE TABLE menu_item_url (
                    id INT UNSIGNED NOT NULL, 
                    url VARCHAR(255) NOT NULL,
                    CONSTRAINT FK_2F7E5681BF396750 FOREIGN KEY (id) REFERENCES menu_item (id) ON DELETE CASCADE,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                ALTER TABLE menu_item 
                    ADD discriminator VARCHAR(255) NOT NULL AFTER `position`
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                UPDATE menu_item SET discriminator = 'menu' WHERE discriminator IS NULL OR discriminator = ''
            SQL,
        );
    }
}
