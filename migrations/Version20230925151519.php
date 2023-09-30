<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925151519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE validation (id INT AUTO_INCREMENT NOT NULL, depot_id INT NOT NULL, raison LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, UNIQUE INDEX UNIQ_16AC5B6E8510D4DE (depot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6E8510D4DE FOREIGN KEY (depot_id) REFERENCES demande_clinique_depots (id)');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD validation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD CONSTRAINT FK_93FCCFE0A2274850 FOREIGN KEY (validation_id) REFERENCES validation (id)');
        $this->addSql('CREATE INDEX IDX_93FCCFE0A2274850 ON demande_clinique_reponses (validation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP FOREIGN KEY FK_93FCCFE0A2274850');
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6E8510D4DE');
        $this->addSql('DROP TABLE validation');
        $this->addSql('DROP INDEX IDX_93FCCFE0A2274850 ON demande_clinique_reponses');
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP validation_id');
    }
}