<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615031500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create API token table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token_hash VARCHAR(64) NOT NULL, expires_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7BA2F5EBA76ED395 (user_id), UNIQUE INDEX UNIQ_API_TOKEN_HASH (token_hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_API_TOKEN_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_API_TOKEN_USER');
        $this->addSql('DROP TABLE api_token');
    }
}
