<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122193237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person_group ADD position INT NOT NULL AFTER enabled');

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE person_group SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );
    }
}
