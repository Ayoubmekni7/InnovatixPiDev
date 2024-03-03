<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302205724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F73172433D06');
        $this->addSql('ALTER TABLE stagiaire DROP FOREIGN KEY FK_4F62F731FEF1BA4');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE stagiaire');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, id_stage_id INT NOT NULL, encadrant_id INT NOT NULL, INDEX IDX_4F62F731FEF1BA4 (encadrant_id), INDEX IDX_4F62F73172433D06 (id_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F73172433D06 FOREIGN KEY (id_stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE stagiaire ADD CONSTRAINT FK_4F62F731FEF1BA4 FOREIGN KEY (encadrant_id) REFERENCES employee (id)');
    }
}
