<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103213617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
                ALTER TABLE sponsor 
                    ADD position INT NOT NULL AFTER image_id
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                SET @current = -1;
                UPDATE sponsor SET position=(@current:=@current+1) WHERE 1;
            SQL,
        );
    }
}
