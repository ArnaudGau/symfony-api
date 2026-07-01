<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260629000246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dictionnary_user DROP FOREIGN KEY `FK_CF2152CA9D86650F`');
        $this->addSql('ALTER TABLE dictionnary_user DROP FOREIGN KEY `FK_CF2152CABB7FE49`');
        $this->addSql('DROP INDEX IDX_CF2152CABB7FE49 ON dictionnary_user');
        $this->addSql('DROP INDEX IDX_CF2152CA9D86650F ON dictionnary_user');
        $this->addSql('ALTER TABLE dictionnary_user ADD user_id INT NOT NULL, ADD dictionnary_id INT NOT NULL, DROP dictionnary_id_id, DROP user_id_id, CHANGE completion completion INT NOT NULL');
        $this->addSql('ALTER TABLE dictionnary_user ADD CONSTRAINT FK_CF2152CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dictionnary_user ADD CONSTRAINT FK_CF2152CAA3D64E50 FOREIGN KEY (dictionnary_id) REFERENCES dictionnary (id)');
        $this->addSql('CREATE INDEX IDX_CF2152CAA76ED395 ON dictionnary_user (user_id)');
        $this->addSql('CREATE INDEX IDX_CF2152CAA3D64E50 ON dictionnary_user (dictionnary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dictionnary_user DROP FOREIGN KEY FK_CF2152CAA76ED395');
        $this->addSql('ALTER TABLE dictionnary_user DROP FOREIGN KEY FK_CF2152CAA3D64E50');
        $this->addSql('DROP INDEX IDX_CF2152CAA76ED395 ON dictionnary_user');
        $this->addSql('DROP INDEX IDX_CF2152CAA3D64E50 ON dictionnary_user');
        $this->addSql('ALTER TABLE dictionnary_user ADD dictionnary_id_id INT NOT NULL, ADD user_id_id INT NOT NULL, DROP user_id, DROP dictionnary_id, CHANGE completion completion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dictionnary_user ADD CONSTRAINT `FK_CF2152CA9D86650F` FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE dictionnary_user ADD CONSTRAINT `FK_CF2152CABB7FE49` FOREIGN KEY (dictionnary_id_id) REFERENCES dictionnary (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CF2152CABB7FE49 ON dictionnary_user (dictionnary_id_id)');
        $this->addSql('CREATE INDEX IDX_CF2152CA9D86650F ON dictionnary_user (user_id_id)');
    }
}
