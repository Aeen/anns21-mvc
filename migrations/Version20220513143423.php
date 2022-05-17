<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513143423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adventure ADD COLUMN name VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__adventure AS SELECT id, life, food, snail, banana, keys, potion FROM adventure');
        $this->addSql('DROP TABLE adventure');
        $this->addSql('CREATE TABLE adventure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, life INTEGER NOT NULL, food INTEGER NOT NULL, snail INTEGER NOT NULL, banana INTEGER NOT NULL, keys INTEGER NOT NULL, potion INTEGER NOT NULL)');
        $this->addSql('INSERT INTO adventure (id, life, food, snail, banana, keys, potion) SELECT id, life, food, snail, banana, keys, potion FROM __temp__adventure');
        $this->addSql('DROP TABLE __temp__adventure');
    }
}
