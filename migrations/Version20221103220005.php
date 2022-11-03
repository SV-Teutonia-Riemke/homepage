<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103220005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE link ADD position INT NOT NULL AFTER uri');
        $this->addSql('ALTER TABLE notification ADD position INT NOT NULL AFTER enabled');
        $this->addSql('ALTER TABLE team ADD position INT NOT NULL AFTER enabled');

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE link SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE notification SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE team SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );
    }
}
