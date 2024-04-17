<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416203754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ADD etat_id INT NOT NULL, ADD note DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_AC634F99D5E86FF ON livre (etat_id)');
        $this->addSql('ALTER TABLE prets ADD livre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prets ADD CONSTRAINT FK_3285EA7A37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE INDEX IDX_3285EA7A37D925CB ON prets (livre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99D5E86FF');
        $this->addSql('DROP INDEX IDX_AC634F99D5E86FF ON livre');
        $this->addSql('ALTER TABLE livre DROP etat_id, DROP note');
        $this->addSql('ALTER TABLE prets DROP FOREIGN KEY FK_3285EA7A37D925CB');
        $this->addSql('DROP INDEX IDX_3285EA7A37D925CB ON prets');
        $this->addSql('ALTER TABLE prets DROP livre_id');
    }
}
