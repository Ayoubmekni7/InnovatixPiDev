<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303105015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A9BFE1CC');
        $this->addSql('CREATE TABLE offre_stage (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(80) NOT NULL, domaine VARCHAR(50) NOT NULL, type_offre VARCHAR(30) NOT NULL, poste_propose INT NOT NULL, experience VARCHAR(255) DEFAULT NULL, niveau JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', language JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', description LONGTEXT NOT NULL, exigence_offre LONGTEXT NOT NULL, date_postu DATE DEFAULT NULL, mots_cles JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', pfe_book VARCHAR(255) DEFAULT NULL, INDEX IDX_955674F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, sujet LONGTEXT NOT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, cin VARCHAR(255) DEFAULT NULL, date_naissance VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, salaire VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, poste VARCHAR(255) DEFAULT NULL, departement VARCHAR(255) DEFAULT NULL, date_eambauche VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, is_blocked TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_stage (user_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_20BE6831A76ED395 (user_id), INDEX IDX_20BE68312298D193 (stage_id), PRIMARY KEY(user_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user_stage ADD CONSTRAINT FK_20BE6831A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_stage ADD CONSTRAINT FK_20BE68312298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('DROP INDEX UNIQ_60349993A9BFE1CC ON contrat');
        $this->addSql('ALTER TABLE contrat DROP sujet, CHANGE dure dure VARCHAR(255) NOT NULL, CHANGE stagiare_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_60349993A76ED395 ON contrat (user_id)');
        $this->addSql('ALTER TABLE demandestage ADD offre_stage_id INT DEFAULT NULL, ADD etat VARCHAR(10) NOT NULL, ADD date DATE NOT NULL, ADD score DOUBLE PRECISION NOT NULL, CHANGE nom nom VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE demandestage ADD CONSTRAINT FK_F8FC91A7195A2A28 FOREIGN KEY (offre_stage_id) REFERENCES offre_stage (id)');
        $this->addSql('CREATE INDEX IDX_F8FC91A7195A2A28 ON demandestage (offre_stage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demandestage DROP FOREIGN KEY FK_F8FC91A7195A2A28');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A76ED395');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashed_token VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stagiaire (id INT AUTO_INCREMENT NOT NULL, id_stage_id INT NOT NULL, encadrant_id INT NOT NULL, INDEX IDX_4F62F73172433D06 (id_stage_id), INDEX IDX_4F62F731FEF1BA4 (encadrant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE offre_stage DROP FOREIGN KEY FK_955674F2A76ED395');
        $this->addSql('ALTER TABLE user_stage DROP FOREIGN KEY FK_20BE6831A76ED395');
        $this->addSql('ALTER TABLE user_stage DROP FOREIGN KEY FK_20BE68312298D193');
        $this->addSql('DROP TABLE offre_stage');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_stage');
        $this->addSql('DROP INDEX UNIQ_60349993A76ED395 ON contrat');
        $this->addSql('ALTER TABLE contrat ADD sujet LONGTEXT NOT NULL, CHANGE dure dure INT NOT NULL, CHANGE user_id stagiare_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A9BFE1CC FOREIGN KEY (stagiare_id) REFERENCES stagiaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_60349993A9BFE1CC ON contrat (stagiare_id)');
        $this->addSql('DROP INDEX IDX_F8FC91A7195A2A28 ON demandestage');
        $this->addSql('ALTER TABLE demandestage DROP offre_stage_id, DROP etat, DROP date, DROP score, CHANGE nom nom VARCHAR(30) NOT NULL');
    }
}
