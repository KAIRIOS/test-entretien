<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016162430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'This migration add the validated_at and the validation_reason columns to the demande_clinique_reponses table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD validated_at DATETIME DEFAULT NULL, ADD validation_reason LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP validated_at, DROP validation_reason');
    }
}
