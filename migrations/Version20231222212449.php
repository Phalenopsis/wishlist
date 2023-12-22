<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231222212449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, whish_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_EA750E81B35BBAD (whish_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label_proposition (label_id INT NOT NULL, proposition_id INT NOT NULL, INDEX IDX_2C1113A533B92F39 (label_id), INDEX IDX_2C1113A5DB96F9E (proposition_id), PRIMARY KEY(label_id, proposition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposition (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, wish_list_id INT DEFAULT NULL, content LONGTEXT NOT NULL, difficulty INT NOT NULL, INDEX IDX_C7CDC35361220EA6 (creator_id), INDEX IDX_C7CDC353D69F3311 (wish_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wish_list (id INT AUTO_INCREMENT NOT NULL, creator_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5B8739BD61220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wish_list_user (wish_list_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8F75446D69F3311 (wish_list_id), INDEX IDX_8F75446A76ED395 (user_id), PRIMARY KEY(wish_list_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E81B35BBAD FOREIGN KEY (whish_list_id) REFERENCES wish_list (id)');
        $this->addSql('ALTER TABLE label_proposition ADD CONSTRAINT FK_2C1113A533B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE label_proposition ADD CONSTRAINT FK_2C1113A5DB96F9E FOREIGN KEY (proposition_id) REFERENCES proposition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC35361220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proposition ADD CONSTRAINT FK_C7CDC353D69F3311 FOREIGN KEY (wish_list_id) REFERENCES wish_list (id)');
        $this->addSql('ALTER TABLE wish_list ADD CONSTRAINT FK_5B8739BD61220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wish_list_user ADD CONSTRAINT FK_8F75446D69F3311 FOREIGN KEY (wish_list_id) REFERENCES wish_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wish_list_user ADD CONSTRAINT FK_8F75446A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E81B35BBAD');
        $this->addSql('ALTER TABLE label_proposition DROP FOREIGN KEY FK_2C1113A533B92F39');
        $this->addSql('ALTER TABLE label_proposition DROP FOREIGN KEY FK_2C1113A5DB96F9E');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC35361220EA6');
        $this->addSql('ALTER TABLE proposition DROP FOREIGN KEY FK_C7CDC353D69F3311');
        $this->addSql('ALTER TABLE wish_list DROP FOREIGN KEY FK_5B8739BD61220EA6');
        $this->addSql('ALTER TABLE wish_list_user DROP FOREIGN KEY FK_8F75446D69F3311');
        $this->addSql('ALTER TABLE wish_list_user DROP FOREIGN KEY FK_8F75446A76ED395');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE label_proposition');
        $this->addSql('DROP TABLE proposition');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wish_list');
        $this->addSql('DROP TABLE wish_list_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
