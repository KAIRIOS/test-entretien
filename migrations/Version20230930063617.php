<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230930063617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE validation ADD CONSTRAINT FK_16AC5B6ECF18BB82 FOREIGN KEY (reponse_id) REFERENCES demande_clinique_reponses (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16AC5B6ECF18BB82 ON validation (reponse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE validation DROP FOREIGN KEY FK_16AC5B6ECF18BB82');
        $this->addSql('DROP INDEX UNIQ_16AC5B6ECF18BB82 ON validation');
    }
}
