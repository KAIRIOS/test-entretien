<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027100035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse_validation (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, date_creation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD reponse_validation_id INT DEFAULT NULL, ADD is_valide TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD CONSTRAINT FK_93FCCFE089E3719D FOREIGN KEY (reponse_validation_id) REFERENCES reponse_validation (id)');
        $this->addSql('CREATE INDEX IDX_93FCCFE089E3719D ON demande_clinique_reponses (reponse_validation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP FOREIGN KEY FK_93FCCFE089E3719D');
        $this->addSql('DROP TABLE reponse_validation');
        $this->addSql('DROP INDEX IDX_93FCCFE089E3719D ON demande_clinique_reponses');
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP reponse_validation_id, DROP is_valide');
    }
}
