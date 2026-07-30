<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260730120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Store the IGDB rating separately from the local five-star rating';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE video_game ADD igdb_rating DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE video_game DROP igdb_rating');
    }
}
