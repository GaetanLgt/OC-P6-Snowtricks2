<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230827095953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaires_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE commentaires DROP CONSTRAINT fk_d9bec0c4b281be2e');
        $this->addSql('ALTER TABLE commentaires DROP CONSTRAINT fk_d9bec0c460bb6fe6');
        $this->addSql('ALTER TABLE category_trick DROP CONSTRAINT fk_30c3e65712469de2');
        $this->addSql('ALTER TABLE category_trick DROP CONSTRAINT fk_30c3e657b281be2e');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT fk_6a2ca10cb281be2e');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE category_trick');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE trick RENAME COLUMN nom TO name');
        $this->addSql('ALTER TABLE trick RENAME COLUMN image_mise_en_avant TO thumbnail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaires_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commentaires (id INT NOT NULL, trick_id INT DEFAULT NULL, auteur_id INT DEFAULT NULL, contenu TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, pseudo_auteur VARCHAR(255) NOT NULL, image_profil_auteur VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d9bec0c460bb6fe6 ON commentaires (auteur_id)');
        $this->addSql('CREATE INDEX idx_d9bec0c4b281be2e ON commentaires (trick_id)');
        $this->addSql('COMMENT ON COLUMN commentaires.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, alias VARCHAR(255) DEFAULT NULL, image_profil VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON "user" (email)');
        $this->addSql('CREATE TABLE category_trick (category_id INT NOT NULL, trick_id INT NOT NULL, PRIMARY KEY(category_id, trick_id))');
        $this->addSql('CREATE INDEX idx_30c3e657b281be2e ON category_trick (trick_id)');
        $this->addSql('CREATE INDEX idx_30c3e65712469de2 ON category_trick (category_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, trick_id INT NOT NULL, url VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6a2ca10cb281be2e ON media (trick_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT fk_d9bec0c4b281be2e FOREIGN KEY (trick_id) REFERENCES trick (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT fk_d9bec0c460bb6fe6 FOREIGN KEY (auteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_trick ADD CONSTRAINT fk_30c3e65712469de2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_trick ADD CONSTRAINT fk_30c3e657b281be2e FOREIGN KEY (trick_id) REFERENCES trick (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT fk_6a2ca10cb281be2e FOREIGN KEY (trick_id) REFERENCES trick (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trick RENAME COLUMN name TO nom');
        $this->addSql('ALTER TABLE trick RENAME COLUMN thumbnail TO image_mise_en_avant');
    }
}
