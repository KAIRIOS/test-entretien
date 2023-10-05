<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231003184623 extends AbstractMigration
{
    public function up(Schema $schema): void
    {    
        $this->addSql('ALTER TABLE demande_clinique_reponses ADD validee TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {        
        $this->addSql('ALTER TABLE demande_clinique_reponses DROP validee');
    }
}
