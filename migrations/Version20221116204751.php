<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221116204751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE person_group_member CHANGE position job_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE person_group_member ADD position INT NOT NULL AFTER group_id');

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE person_group_member SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );
    }
}
