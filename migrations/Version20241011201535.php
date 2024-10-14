<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011201535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pattern_collection_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, CONSTRAINT FK_70E4FA782FAE84F5 FOREIGN KEY (pattern_collection_id) REFERENCES pattern_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA782FAE84F5 ON member (pattern_collection_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON member (email)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__crochet_pattern AS SELECT id, collection_id, name, hook_size, category, language, image, designer FROM crochet_pattern');
        $this->addSql('DROP TABLE crochet_pattern');
        $this->addSql('CREATE TABLE crochet_pattern (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, pattern_collection_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, hook_size DOUBLE PRECISION DEFAULT NULL, category VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, image CLOB NOT NULL --(DC2Type:array)
        , designer VARCHAR(255) NOT NULL, CONSTRAINT FK_3B9E020C2FAE84F5 FOREIGN KEY (pattern_collection_id) REFERENCES pattern_collection (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO crochet_pattern (id, pattern_collection_id, name, hook_size, category, language, image, designer) SELECT id, collection_id, name, hook_size, category, language, image, designer FROM __temp__crochet_pattern');
        $this->addSql('DROP TABLE __temp__crochet_pattern');
        $this->addSql('CREATE INDEX IDX_3B9E020C2FAE84F5 ON crochet_pattern (pattern_collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE member');
        $this->addSql('CREATE TEMPORARY TABLE __temp__crochet_pattern AS SELECT id, pattern_collection_id, name, hook_size, category, language, image, designer FROM crochet_pattern');
        $this->addSql('DROP TABLE crochet_pattern');
        $this->addSql('CREATE TABLE crochet_pattern (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collection_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, hook_size DOUBLE PRECISION DEFAULT NULL, category VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, image CLOB NOT NULL --(DC2Type:array)
        , designer VARCHAR(255) NOT NULL, CONSTRAINT FK_3B9E020C514956FD FOREIGN KEY (collection_id) REFERENCES pattern_collection (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO crochet_pattern (id, collection_id, name, hook_size, category, language, image, designer) SELECT id, pattern_collection_id, name, hook_size, category, language, image, designer FROM __temp__crochet_pattern');
        $this->addSql('DROP TABLE __temp__crochet_pattern');
        $this->addSql('CREATE INDEX IDX_3B9E020C514956FD ON crochet_pattern (collection_id)');
    }
}
