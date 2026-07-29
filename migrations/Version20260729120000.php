<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260729120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename game_editor and game_developer tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('RENAME TABLE game_editor TO editor, game_developer TO developer');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('RENAME TABLE editor TO game_editor, developer TO game_developer');
    }
}
