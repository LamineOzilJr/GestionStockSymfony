<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221222002742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(50) DEFAULT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entree (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, user_id INT DEFAULT NULL, date_e DATE NOT NULL, qt_e NUMERIC(10, 0) NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_598377A6F347EFB (produit_id), INDEX IDX_598377A6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreec (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, user_id INT DEFAULT NULL, date_e DATE NOT NULL, qt_e NUMERIC(10, 0) NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_39555AC5F347EFB (produit_id), INDEX IDX_39555AC5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreef (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, date_e DATE NOT NULL, qt_e NUMERIC(10, 0) NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_493FAE4AF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, categorie VARCHAR(200) NOT NULL, qt_stock NUMERIC(10, 0) NOT NULL, INDEX IDX_29A5EC27A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produitc (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, categorie VARCHAR(200) NOT NULL, qt_stock NUMERIC(10, 0) NOT NULL, INDEX IDX_A39ACFE8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produitf (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, categorie VARCHAR(200) NOT NULL, qt_stock NUMERIC(10, 0) NOT NULL, INDEX IDX_D3F03B67A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortie (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, user_id INT DEFAULT NULL, date_s DATE NOT NULL, qt_s NUMERIC(10, 0) NOT NULL, categorie VARCHAR(200) NOT NULL, INDEX IDX_3C3FD3F2F347EFB (produit_id), INDEX IDX_3C3FD3F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortiec (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, boutique_id INT NOT NULL, user_id INT DEFAULT NULL, date_s DATE NOT NULL, qt_s NUMERIC(10, 0) NOT NULL, categorie VARCHAR(200) NOT NULL, INDEX IDX_5536738CF347EFB (produit_id), INDEX IDX_5536738CAB677BE6 (boutique_id), INDEX IDX_5536738CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sortief (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, user_id INT DEFAULT NULL, date_s DATE NOT NULL, qt_s NUMERIC(10, 0) NOT NULL, categorie VARCHAR(200) NOT NULL, INDEX IDX_255C8703F347EFB (produit_id), INDEX IDX_255C8703A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE entree ADD CONSTRAINT FK_598377A6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entreec ADD CONSTRAINT FK_39555AC5F347EFB FOREIGN KEY (produit_id) REFERENCES produitc (id)');
        $this->addSql('ALTER TABLE entreec ADD CONSTRAINT FK_39555AC5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE entreef ADD CONSTRAINT FK_493FAE4AF347EFB FOREIGN KEY (produit_id) REFERENCES produitf (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produitc ADD CONSTRAINT FK_A39ACFE8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produitf ADD CONSTRAINT FK_D3F03B67A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE sortie ADD CONSTRAINT FK_3C3FD3F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sortiec ADD CONSTRAINT FK_5536738CF347EFB FOREIGN KEY (produit_id) REFERENCES produitc (id)');
        $this->addSql('ALTER TABLE sortiec ADD CONSTRAINT FK_5536738CAB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('ALTER TABLE sortiec ADD CONSTRAINT FK_5536738CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sortief ADD CONSTRAINT FK_255C8703F347EFB FOREIGN KEY (produit_id) REFERENCES produitf (id)');
        $this->addSql('ALTER TABLE sortief ADD CONSTRAINT FK_255C8703A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sortiec DROP FOREIGN KEY FK_5536738CAB677BE6');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6F347EFB');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2F347EFB');
        $this->addSql('ALTER TABLE entreec DROP FOREIGN KEY FK_39555AC5F347EFB');
        $this->addSql('ALTER TABLE sortiec DROP FOREIGN KEY FK_5536738CF347EFB');
        $this->addSql('ALTER TABLE entreef DROP FOREIGN KEY FK_493FAE4AF347EFB');
        $this->addSql('ALTER TABLE sortief DROP FOREIGN KEY FK_255C8703F347EFB');
        $this->addSql('ALTER TABLE entree DROP FOREIGN KEY FK_598377A6A76ED395');
        $this->addSql('ALTER TABLE entreec DROP FOREIGN KEY FK_39555AC5A76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A76ED395');
        $this->addSql('ALTER TABLE produitc DROP FOREIGN KEY FK_A39ACFE8A76ED395');
        $this->addSql('ALTER TABLE produitf DROP FOREIGN KEY FK_D3F03B67A76ED395');
        $this->addSql('ALTER TABLE sortie DROP FOREIGN KEY FK_3C3FD3F2A76ED395');
        $this->addSql('ALTER TABLE sortiec DROP FOREIGN KEY FK_5536738CA76ED395');
        $this->addSql('ALTER TABLE sortief DROP FOREIGN KEY FK_255C8703A76ED395');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE entree');
        $this->addSql('DROP TABLE entreec');
        $this->addSql('DROP TABLE entreef');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produitc');
        $this->addSql('DROP TABLE produitf');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE sortie');
        $this->addSql('DROP TABLE sortiec');
        $this->addSql('DROP TABLE sortief');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
