<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212183823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD credit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86CE062FF9 FOREIGN KEY (credit_id) REFERENCES credit (id)');
        $this->addSql('CREATE INDEX IDX_10C31F86CE062FF9 ON rdv (credit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86CE062FF9');
        $this->addSql('DROP INDEX IDX_10C31F86CE062FF9 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP credit_id');
    }
}
