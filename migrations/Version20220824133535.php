<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824133535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Setup';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT UNSIGNED AUTO_INCREMENT NOT NULL, image_id INT UNSIGNED DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, enabled TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_23A0E663DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_setting (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE directory (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', INDEX IDX_467844DA727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT UNSIGNED AUTO_INCREMENT NOT NULL, directory_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, safe_name VARCHAR(255) NOT NULL, extension VARCHAR(255) DEFAULT NULL, mime_type VARCHAR(255) DEFAULT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', file_path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_8C9F3610D17F50A6 (uuid), UNIQUE INDEX UNIQ_8C9F361082A8E361 (file_path), INDEX IDX_8C9F36102C94069F (directory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT UNSIGNED AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, enabled TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT UNSIGNED AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT UNSIGNED AUTO_INCREMENT NOT NULL, image_id INT UNSIGNED DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, anonymize_last_name TINYINT(1) DEFAULT 1 NOT NULL, phone_number VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', email_address VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_34DCD1763DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_group (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_group_member (id INT UNSIGNED AUTO_INCREMENT NOT NULL, person_id INT UNSIGNED NOT NULL, group_id INT UNSIGNED NOT NULL, position VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', INDEX IDX_406CC2E5217BBB47 (person_id), INDEX IDX_406CC2E5FE54D947 (group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT UNSIGNED AUTO_INCREMENT NOT NULL, person_id INT UNSIGNED NOT NULL, team_id INT UNSIGNED NOT NULL, image_id INT UNSIGNED DEFAULT NULL, number INT UNSIGNED DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', INDEX IDX_98197A65217BBB47 (person_id), INDEX IDX_98197A65296CD8AE (team_id), UNIQUE INDEX UNIQ_98197A653DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT UNSIGNED AUTO_INCREMENT NOT NULL, image_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_818CC9D43DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT UNSIGNED AUTO_INCREMENT NOT NULL, person_id INT UNSIGNED NOT NULL, team_id INT UNSIGNED NOT NULL, image_id INT UNSIGNED DEFAULT NULL, position VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', INDEX IDX_426EF392217BBB47 (person_id), INDEX IDX_426EF392296CD8AE (team_id), UNIQUE INDEX UNIQ_426EF3923DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE symfony_session (session_id VARCHAR(255) NOT NULL, session_data LONGBLOB DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', PRIMARY KEY(session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT UNSIGNED AUTO_INCREMENT NOT NULL, image_id INT UNSIGNED DEFAULT NULL, name VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, age_category VARCHAR(255) DEFAULT NULL, junior_age VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, current_matchday VARCHAR(255) DEFAULT NULL, handball_net_id VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_C4E0A61F3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetimeutc)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetimeutc)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E663DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE directory ADD CONSTRAINT FK_467844DA727ACA70 FOREIGN KEY (parent_id) REFERENCES directory (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36102C94069F FOREIGN KEY (directory_id) REFERENCES directory (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1763DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE person_group_member ADD CONSTRAINT FK_406CC2E5217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_group_member ADD CONSTRAINT FK_406CC2E5FE54D947 FOREIGN KEY (group_id) REFERENCES person_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A653DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D43DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF3923DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
    }
}
