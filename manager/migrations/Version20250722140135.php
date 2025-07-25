<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722140135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_comments (id UUID NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, author_id UUID NOT NULL, text TEXT NOT NULL, update_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, version INT DEFAULT 1 NOT NULL, entity_type VARCHAR(255) NOT NULL, entity_id VARCHAR(36) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42DAF52CAA9E377A ON comment_comments (date)');
        $this->addSql('CREATE INDEX IDX_42DAF52CC412EE0281257D5D ON comment_comments (entity_type, entity_id)');
        $this->addSql('COMMENT ON COLUMN comment_comments.id IS \'(DC2Type:comment_comment_id)\'');
        $this->addSql('COMMENT ON COLUMN comment_comments.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN comment_comments.author_id IS \'(DC2Type:comment_comment_author_id)\'');
        $this->addSql('COMMENT ON COLUMN comment_comments.update_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE comment_comments');
    }
}
