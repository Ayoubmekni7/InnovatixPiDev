<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214003938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD objet_rec VARCHAR(255) NOT NULL, ADD contenu_rec VARCHAR(255) NOT NULL, ADD adr_rec VARCHAR(255) NOT NULL, ADD statut_rec VARCHAR(255) NOT NULL, DROP objet, DROP contenu, DROP adresse_rec, DROP date_mrec, DROP stat_rec');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC7CF18BB82 ON reponse');
        $this->addSql('ALTER TABLE reponse ADD reclamation_id INT DEFAULT NULL, ADD adr_rep VARCHAR(255) NOT NULL, ADD contenu_rep VARCHAR(255) NOT NULL, DROP reponse_id, DROP adresse_rep, DROP contenu_rep_r');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC72D6BA2D9 ON reponse (reclamation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD objet VARCHAR(255) NOT NULL, ADD contenu VARCHAR(255) NOT NULL, ADD adresse_rec VARCHAR(255) NOT NULL, ADD date_mrec DATETIME NOT NULL, ADD stat_rec VARCHAR(255) NOT NULL, DROP objet_rec, DROP contenu_rec, DROP adr_rec, DROP statut_rec');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('DROP INDEX IDX_5FB6DEC72D6BA2D9 ON reponse');
        $this->addSql('ALTER TABLE reponse ADD reponse_id INT NOT NULL, ADD adresse_rep VARCHAR(255) NOT NULL, ADD contenu_rep_r VARCHAR(255) NOT NULL, DROP reclamation_id, DROP adr_rep, DROP contenu_rep');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC7CF18BB82 ON reponse (reponse_id)');
    }
}
