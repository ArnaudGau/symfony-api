<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260705120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add dictionnary categories table and link dictionnary entries to categories';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE dictionnary_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO dictionnary_categories (name) VALUES ('Default')");
        $this->addSql('ALTER TABLE dictionnary ADD category_id INT DEFAULT NULL');
        $this->addSql("UPDATE dictionnary SET category_id = (SELECT id FROM dictionnary_categories WHERE name = 'Default' ORDER BY id ASC LIMIT 1)");
        $this->addSql('ALTER TABLE dictionnary CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE dictionnary ADD CONSTRAINT FK_A870FB6512469DE2 FOREIGN KEY (category_id) REFERENCES dictionnary_categories (id)');
        $this->addSql('CREATE INDEX IDX_A870FB6512469DE2 ON dictionnary (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dictionnary DROP FOREIGN KEY FK_A870FB6512469DE2');
        $this->addSql('DROP INDEX IDX_A870FB6512469DE2 ON dictionnary');
        $this->addSql('ALTER TABLE dictionnary DROP category_id');
        $this->addSql('DROP TABLE dictionnary_categories');
    }
}
