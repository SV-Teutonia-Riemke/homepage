<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509143508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE download CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE link CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu_item CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person_group CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE person_group_member CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sponsor CHANGE position position INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team CHANGE position position INT DEFAULT NULL');
    }
}
