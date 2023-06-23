<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623172515 extends AbstractMigration
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
                    ADD level VARCHAR(255) DEFAULT 'sponsor' NOT NULL AFTER url;
            SQL,
        );

        $this->addSql(
            <<<'SQL'
                ALTER TABLE sessions 
                    MODIFY sess_data LONGBLOB NOT NULL,
                    DROP INDEX sessions_sess_lifetime_idx,
                    ADD INDEX sess_lifetime_idx (sess_lifetime);
            SQL,
        );
    }
}
