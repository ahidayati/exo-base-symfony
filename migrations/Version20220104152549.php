<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104152549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(120) NOT NULL, email VARCHAR(255) NOT NULL, nickname VARCHAR(255) DEFAULT NULL, wallet DOUBLE PRECISION DEFAULT \'0\' NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, game_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, up_votes INT DEFAULT 0 NOT NULL, down_votes INT DEFAULT 0 NOT NULL, INDEX IDX_9474526C9B6B5FBA (account_id), INDEX IDX_9474526CE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, published_at DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT DEFAULT NULL, thumbnail_cover VARCHAR(255) DEFAULT NULL, thumbnail_logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_language (game_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_7F9F8E93E48FD905 (game_id), INDEX IDX_7F9F8E9382F1BAF4 (language_id), PRIMARY KEY(game_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_genre (game_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_B1634A77E48FD905 (game_id), INDEX IDX_B1634A774296D31F (genre_id), PRIMARY KEY(game_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, flag VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE library (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, account_id INT DEFAULT NULL, installed TINYINT(1) DEFAULT \'0\' NOT NULL, game_time INT DEFAULT 0 NOT NULL, last_used DATETIME DEFAULT NULL, INDEX IDX_A18098BCE48FD905 (game_id), INDEX IDX_A18098BC9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_language ADD CONSTRAINT FK_7F9F8E93E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_language ADD CONSTRAINT FK_7F9F8E9382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A77E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_genre ADD CONSTRAINT FK_B1634A774296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BCE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE library ADD CONSTRAINT FK_A18098BC9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C9B6B5FBA');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BC9B6B5FBA');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE48FD905');
        $this->addSql('ALTER TABLE game_language DROP FOREIGN KEY FK_7F9F8E93E48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A77E48FD905');
        $this->addSql('ALTER TABLE library DROP FOREIGN KEY FK_A18098BCE48FD905');
        $this->addSql('ALTER TABLE game_genre DROP FOREIGN KEY FK_B1634A774296D31F');
        $this->addSql('ALTER TABLE game_language DROP FOREIGN KEY FK_7F9F8E9382F1BAF4');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_language');
        $this->addSql('DROP TABLE game_genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE library');
    }
}
