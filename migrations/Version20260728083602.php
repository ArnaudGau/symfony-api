<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260728083602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_editor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dictionnary RENAME INDEX idx_a870fb6512469de2 TO IDX_8C3ED7B912469DE2');
        $this->addSql('ALTER TABLE dictionnary_user CHANGE completion completion INT DEFAULT 0 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_USER_DICTIONNARY ON dictionnary_user (user_id, dictionnary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_editor');
        $this->addSql('ALTER TABLE dictionnary RENAME INDEX idx_8c3ed7b912469de2 TO IDX_A870FB6512469DE2');
        $this->addSql('DROP INDEX UNIQUE_USER_DICTIONNARY ON dictionnary_user');
        $this->addSql('ALTER TABLE dictionnary_user CHANGE completion completion INT NOT NULL');
    }
}
