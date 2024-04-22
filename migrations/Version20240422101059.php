<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422101059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ADD date_rendu VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prets ADD user_id INT NOT NULL, CHANGE date_debut date_debut DATETIME NOT NULL, CHANGE date_fin date_fin DATETIME NOT NULL, CHANGE date_rendu date_rendu DATETIME DEFAULT NULL, CHANGE extension extension TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE prets ADD CONSTRAINT FK_3285EA7AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_3285EA7AA76ED395 ON prets (user_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP date_rendu');
        $this->addSql('ALTER TABLE prets DROP FOREIGN KEY FK_3285EA7AA76ED395');
        $this->addSql('DROP INDEX IDX_3285EA7AA76ED395 ON prets');
        $this->addSql('ALTER TABLE prets DROP user_id, CHANGE date_fin date_fin INT NOT NULL, CHANGE date_debut date_debut INT NOT NULL, CHANGE date_rendu date_rendu INT NOT NULL, CHANGE extension extension INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }
}
