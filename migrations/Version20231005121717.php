<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Enum\DemandeClinique\Reponse\Status;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005121717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add status property to Reponse entity, and a new table for ReponseWorkflowLog entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_clinique_reponse_workflow_logs (id INT AUTO_INCREMENT NOT NULL, reponse_id INT NOT NULL, transition VARCHAR(20) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_776D41FBCF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_clinique_reponse_workflow_logs ADD CONSTRAINT FK_776D41FBCF18BB82 FOREIGN KEY (reponse_id) REFERENCES demande_clinique_reponses (id)');
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD status VARCHAR(20) NOT NULL');
        $this->addSql('UPDATE demande_clinique_reponses SET status = \''.Status::WAITING.'\' WHERE status IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_clinique_reponse_workflow_logs DROP FOREIGN KEY FK_776D41FBCF18BB82');
        $this->addSql('DROP TABLE demande_clinique_reponse_workflow_logs');
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP status');
    }
}
