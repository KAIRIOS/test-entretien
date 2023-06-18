<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618123028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_clinique_raison_validation (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD raison_validation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD CONSTRAINT FK_93FCCFE05A7B2F85 FOREIGN KEY (raison_validation_id) REFERENCES demande_clinique_raison_validation (id)');
        $this->addSql('CREATE INDEX IDX_93FCCFE05A7B2F85 ON demande_clinique_reponses (raison_validation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP FOREIGN KEY FK_93FCCFE05A7B2F85');
        $this->addSql('DROP TABLE demande_clinique_raison_validation');
        $this->addSql('DROP INDEX IDX_93FCCFE05A7B2F85 ON demande_clinique_reponses');
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP raison_validation_id');
    }
}
