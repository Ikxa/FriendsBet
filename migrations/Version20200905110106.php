<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200905110106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet ADD user_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B1ED93D47 FOREIGN KEY (user_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_FBF0EC9B1ED93D47 ON bet (user_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B1ED93D47');
        $this->addSql('DROP INDEX IDX_FBF0EC9B1ED93D47 ON bet');
        $this->addSql('ALTER TABLE bet DROP user_group_id');
    }
}
