<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260730100000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add the unique IGDB identifier to video games';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE video_game ADD igdb_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24BC6C50F22E1B8D ON video_game (igdb_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX UNIQ_24BC6C50F22E1B8D ON video_game');
        $this->addSql('ALTER TABLE video_game DROP igdb_id');
    }
}
