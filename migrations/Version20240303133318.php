<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303133318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_debut DATE NOT NULL, dure VARCHAR(255) NOT NULL, datefin DATE NOT NULL, UNIQUE INDEX UNIQ_60349993A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demandestage (id INT AUTO_INCREMENT NOT NULL, offre_stage_id INT DEFAULT NULL, nom VARCHAR(30) DEFAULT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(40) NOT NULL, numerotelephone INT NOT NULL, lettremotivation LONGTEXT DEFAULT NULL, cv VARCHAR(50) DEFAULT NULL, domaine VARCHAR(50) DEFAULT NULL, etat VARCHAR(10) NOT NULL, date DATE NOT NULL, score DOUBLE PRECISION NOT NULL, INDEX IDX_F8FC91A7195A2A28 (offre_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_stage (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(80) NOT NULL, domaine VARCHAR(50) NOT NULL, type_offre VARCHAR(30) NOT NULL, poste_propose INT NOT NULL, experience VARCHAR(255) DEFAULT NULL, niveau JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', language JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', description LONGTEXT NOT NULL, exigence_offre LONGTEXT NOT NULL, date_postu DATE DEFAULT NULL, mots_cles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', pfe_book VARCHAR(255) DEFAULT NULL, INDEX IDX_955674F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, sujet LONGTEXT NOT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stage (user_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_20BE6831A76ED395 (user_id), INDEX IDX_20BE68312298D193 (stage_id), PRIMARY KEY(user_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE demandestage ADD CONSTRAINT FK_F8FC91A7195A2A28 FOREIGN KEY (offre_stage_id) REFERENCES offre_stage (id)');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_stage ADD CONSTRAINT FK_20BE6831A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stage ADD CONSTRAINT FK_20BE68312298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A76ED395');
        $this->addSql('ALTER TABLE demandestage DROP FOREIGN KEY FK_F8FC91A7195A2A28');
        $this->addSql('ALTER TABLE offre_stage DROP FOREIGN KEY FK_955674F2A76ED395');
        $this->addSql('ALTER TABLE user_stage DROP FOREIGN KEY FK_20BE6831A76ED395');
        $this->addSql('ALTER TABLE user_stage DROP FOREIGN KEY FK_20BE68312298D193');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE demandestage');
        $this->addSql('DROP TABLE offre_stage');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE user_stage');
    }
}
