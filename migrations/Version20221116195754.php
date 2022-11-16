<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116195754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE person_group_member DROP FOREIGN KEY FK_406CC2E5217BBB47');
        $this->addSql('ALTER TABLE person_group_member MODIFY person_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE person_group_member ADD CONSTRAINT FK_406CC2E5217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE SET NULL');
    }
}
