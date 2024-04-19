<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418081103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, etat_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, annee_publication INT DEFAULT NULL, resume LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, disponibilite TINYINT(1) NOT NULL, note DOUBLE PRECISION DEFAULT NULL, INDEX IDX_AC634F99D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prets (id INT AUTO_INCREMENT NOT NULL, livre_id INT DEFAULT NULL, date_debut INT NOT NULL, date_fin INT NOT NULL, date_rendu INT NOT NULL, extension INT DEFAULT NULL, INDEX IDX_3285EA7A37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription (id INT AUTO_INCREMENT NOT NULL, subscriptiontype_id INT NOT NULL, startdate DATETIME NOT NULL, enddate DATETIME NOT NULL, INDEX IDX_A3C664D3F5897397 (subscriptiontype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE prets ADD CONSTRAINT FK_3285EA7A37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3F5897397 FOREIGN KEY (subscriptiontype_id) REFERENCES subscription_type (id)');
        $this->addSql('ALTER TABLE user ADD subscription_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499A1887DC FOREIGN KEY (subscription_id) REFERENCES subscription (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6499A1887DC ON user (subscription_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499A1887DC');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99D5E86FF');
        $this->addSql('ALTER TABLE prets DROP FOREIGN KEY FK_3285EA7A37D925CB');
        $this->addSql('ALTER TABLE subscription DROP FOREIGN KEY FK_A3C664D3F5897397');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE prets');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_type');
        $this->addSql('DROP INDEX IDX_8D93D6499A1887DC ON `user`');
        $this->addSql('ALTER TABLE `user` DROP subscription_id');
    }
}
