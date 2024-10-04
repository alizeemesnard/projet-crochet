<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001092916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__crochet_pattern AS SELECT id, name, hook_size, category, language, image, designer FROM crochet_pattern');
        $this->addSql('DROP TABLE crochet_pattern');
        $this->addSql('CREATE TABLE crochet_pattern (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collection_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, hook_size DOUBLE PRECISION DEFAULT NULL, category VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, image CLOB NOT NULL --(DC2Type:array)
        , designer VARCHAR(255) NOT NULL, CONSTRAINT FK_3B9E020C514956FD FOREIGN KEY (collection_id) REFERENCES pattern_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO crochet_pattern (id, name, hook_size, category, language, image, designer) SELECT id, name, hook_size, category, language, image, designer FROM __temp__crochet_pattern');
        $this->addSql('DROP TABLE __temp__crochet_pattern');
        $this->addSql('CREATE INDEX IDX_3B9E020C514956FD ON crochet_pattern (collection_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__pattern_collection AS SELECT id, designer, date_created, total_patterns, name FROM pattern_collection');
        $this->addSql('DROP TABLE pattern_collection');
        $this->addSql('CREATE TABLE pattern_collection (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, designer VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, total_patterns INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO pattern_collection (id, designer, date_created, total_patterns, name) SELECT id, designer, date_created, total_patterns, name FROM __temp__pattern_collection');
        $this->addSql('DROP TABLE __temp__pattern_collection');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__crochet_pattern AS SELECT id, name, hook_size, category, language, image, designer FROM crochet_pattern');
        $this->addSql('DROP TABLE crochet_pattern');
        $this->addSql('CREATE TABLE crochet_pattern (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, hook_size DOUBLE PRECISION DEFAULT NULL, category VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, image CLOB NOT NULL --(DC2Type:array)
        , designer VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO crochet_pattern (id, name, hook_size, category, language, image, designer) SELECT id, name, hook_size, category, language, image, designer FROM __temp__crochet_pattern');
        $this->addSql('DROP TABLE __temp__crochet_pattern');
        $this->addSql('ALTER TABLE pattern_collection ADD COLUMN patterns CLOB DEFAULT NULL');
    }
}
