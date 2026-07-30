<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260729094301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video_game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, rating INT DEFAULT NULL, console_id INT NOT NULL, INDEX IDX_24BC6C5072F9DD9F (console_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE video_game_developer (video_game_id INT NOT NULL, developer_id INT NOT NULL, INDEX IDX_918F001816230A8 (video_game_id), INDEX IDX_918F001864DD9267 (developer_id), PRIMARY KEY (video_game_id, developer_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE video_game_editor (video_game_id INT NOT NULL, editor_id INT NOT NULL, INDEX IDX_9346EDD316230A8 (video_game_id), INDEX IDX_9346EDD36995AC4C (editor_id), PRIMARY KEY (video_game_id, editor_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE video_game ADD CONSTRAINT FK_24BC6C5072F9DD9F FOREIGN KEY (console_id) REFERENCES game_console (id)');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001816230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_game_developer ADD CONSTRAINT FK_918F001864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_game_editor ADD CONSTRAINT FK_9346EDD316230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_game_editor ADD CONSTRAINT FK_9346EDD36995AC4C FOREIGN KEY (editor_id) REFERENCES editor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_game DROP FOREIGN KEY FK_24BC6C5072F9DD9F');
        $this->addSql('ALTER TABLE video_game_developer DROP FOREIGN KEY FK_918F001816230A8');
        $this->addSql('ALTER TABLE video_game_developer DROP FOREIGN KEY FK_918F001864DD9267');
        $this->addSql('ALTER TABLE video_game_editor DROP FOREIGN KEY FK_9346EDD316230A8');
        $this->addSql('ALTER TABLE video_game_editor DROP FOREIGN KEY FK_9346EDD36995AC4C');
        $this->addSql('DROP TABLE video_game');
        $this->addSql('DROP TABLE video_game_developer');
        $this->addSql('DROP TABLE video_game_editor');
    }
}
