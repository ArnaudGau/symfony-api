<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260616075221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dictionnary (id INT AUTO_INCREMENT NOT NULL, word VARCHAR(255) NOT NULL, translation VARCHAR(255) NOT NULL, language_id INT NOT NULL, INDEX IDX_8C3ED7B982F1BAF4 (language_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dictionnary ADD CONSTRAINT FK_8C3ED7B982F1BAF4 FOREIGN KEY (language_id) REFERENCES languages (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dictionnary DROP FOREIGN KEY FK_8C3ED7B982F1BAF4');
        $this->addSql('DROP TABLE dictionnary');
    }
}
