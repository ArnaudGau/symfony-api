<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260730110000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Use IGDB identifiers for catalog references and allow several consoles per game';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE video_game_game_console (video_game_id INT NOT NULL, game_console_id INT NOT NULL, INDEX IDX_CE6F8B2616230A8 (video_game_id), INDEX IDX_CE6F8B269C251A72 (game_console_id), PRIMARY KEY (video_game_id, game_console_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE video_game_game_console ADD CONSTRAINT FK_CE6F8B2616230A8 FOREIGN KEY (video_game_id) REFERENCES video_game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_game_game_console ADD CONSTRAINT FK_CE6F8B269C251A72 FOREIGN KEY (game_console_id) REFERENCES game_console (id) ON DELETE CASCADE');
        $this->addSql('INSERT INTO video_game_game_console (video_game_id, game_console_id) SELECT id, console_id FROM video_game');

        $this->addSql('ALTER TABLE developer ADD igdb_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65FB8B9AF22E1B8D ON developer (igdb_id)');
        $this->addSql('ALTER TABLE editor ADD igdb_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CCF1F1BAF22E1B8D ON editor (igdb_id)');
        $this->addSql('ALTER TABLE game_console ADD igdb_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3C1B099F22E1B8D ON game_console (igdb_id)');

        $this->addSql('ALTER TABLE video_game DROP FOREIGN KEY FK_24BC6C5072F9DD9F');
        $this->addSql('DROP INDEX IDX_24BC6C5072F9DD9F ON video_game');
        $this->addSql('ALTER TABLE video_game DROP console_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE video_game ADD console_id INT DEFAULT NULL');
        $this->addSql('UPDATE video_game SET console_id = (SELECT MIN(game_console_id) FROM video_game_game_console WHERE video_game_id = video_game.id)');
        $this->addSql('ALTER TABLE video_game MODIFY console_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_24BC6C5072F9DD9F ON video_game (console_id)');
        $this->addSql('ALTER TABLE video_game ADD CONSTRAINT FK_24BC6C5072F9DD9F FOREIGN KEY (console_id) REFERENCES game_console (id)');

        $this->addSql('DROP TABLE video_game_game_console');
        $this->addSql('DROP INDEX UNIQ_65FB8B9AF22E1B8D ON developer');
        $this->addSql('ALTER TABLE developer DROP igdb_id');
        $this->addSql('DROP INDEX UNIQ_CCF1F1BAF22E1B8D ON editor');
        $this->addSql('ALTER TABLE editor DROP igdb_id');
        $this->addSql('DROP INDEX UNIQ_A3C1B099F22E1B8D ON game_console');
        $this->addSql('ALTER TABLE game_console DROP igdb_id');
    }
}
