<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513115819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adventure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, life INTEGER NOT NULL, food INTEGER NOT NULL, snail INTEGER NOT NULL, banana INTEGER NOT NULL, keys INTEGER NOT NULL, potion INTEGER NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, title, isbn, author, picture FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(20) NOT NULL, author VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO book (id, title, isbn, author, picture) SELECT id, title, isbn, author, picture FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adventure');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, title, isbn, author, picture FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, isbn VARCHAR(11) NOT NULL, author VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO book (id, title, isbn, author, picture) SELECT id, title, isbn, author, picture FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
    }
}
