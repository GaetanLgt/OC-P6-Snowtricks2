<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230828051207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE categorie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE categorie (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE categorie_trick (categorie_id INT NOT NULL, trick_id INT NOT NULL, PRIMARY KEY(categorie_id, trick_id))');
        $this->addSql('CREATE INDEX IDX_2D8844CEBCF5E72D ON categorie_trick (categorie_id)');
        $this->addSql('CREATE INDEX IDX_2D8844CEB281BE2E ON categorie_trick (trick_id)');
        $this->addSql('ALTER TABLE categorie_trick ADD CONSTRAINT FK_2D8844CEBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE categorie_trick ADD CONSTRAINT FK_2D8844CEB281BE2E FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE categorie_id_seq CASCADE');
        $this->addSql('ALTER TABLE categorie_trick DROP CONSTRAINT FK_2D8844CEBCF5E72D');
        $this->addSql('ALTER TABLE categorie_trick DROP CONSTRAINT FK_2D8844CEB281BE2E');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_trick');
    }
}
