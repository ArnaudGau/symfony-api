<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260816155839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_price_history (id INT AUTO_INCREMENT NOT NULL, price NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, game_id INT NOT NULL, INDEX IDX_E678247CE48FD905 (game_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE game_price_history ADD CONSTRAINT FK_E678247CE48FD905 FOREIGN KEY (game_id) REFERENCES video_game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_price_history DROP FOREIGN KEY FK_E678247CE48FD905');
        $this->addSql('DROP TABLE game_price_history');
    }
}
