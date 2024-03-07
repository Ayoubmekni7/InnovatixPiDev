<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307103205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_commentaire DROP FOREIGN KEY FK_6E5B5DB9BA9CD190');
        $this->addSql('CREATE TABLE commentaire_hadhemi (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, date_creation DATETIME NOT NULL, nom_aut_com VARCHAR(255) NOT NULL, image_u VARCHAR(255) DEFAULT NULL, INDEX IDX_AD5458EC7294869C (article_id), INDEX IDX_AD5458ECA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire_hadhemi ADD CONSTRAINT FK_AD5458EC7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire_hadhemi ADD CONSTRAINT FK_AD5458ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaireHadhemi DROP FOREIGN KEY FK_67F068BC7294869C');
        $this->addSql('ALTER TABLE commentaireHadhemi DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('DROP TABLE commentaireHadhemi');
        $this->addSql('ALTER TABLE reponse_commentaire DROP FOREIGN KEY FK_6E5B5DB9BA9CD190');
        $this->addSql('ALTER TABLE reponse_commentaire ADD CONSTRAINT FK_6E5B5DB9BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire_hadhemi (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse_commentaire DROP FOREIGN KEY FK_6E5B5DB9BA9CD190');
        $this->addSql('CREATE TABLE commentaireHadhemi (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, contenu LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_creation DATETIME NOT NULL, nom_aut_com VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_u VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_67F068BC7294869C (article_id), INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaireHadhemi ADD CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaireHadhemi ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire_hadhemi DROP FOREIGN KEY FK_AD5458EC7294869C');
        $this->addSql('ALTER TABLE commentaire_hadhemi DROP FOREIGN KEY FK_AD5458ECA76ED395');
        $this->addSql('DROP TABLE commentaire_hadhemi');
        $this->addSql('ALTER TABLE reponse_commentaire DROP FOREIGN KEY FK_6E5B5DB9BA9CD190');
        $this->addSql('ALTER TABLE reponse_commentaire ADD CONSTRAINT FK_6E5B5DB9BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaireHadhemi (id)');
    }
}
