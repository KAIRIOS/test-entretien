<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213212817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add isValidate and validationReason to Reponse';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD est_validee TINYINT(1) NOT NULL, ADD raison_validation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP est_validee, DROP raison_validation');
    }
}
