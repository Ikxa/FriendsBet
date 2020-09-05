<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200903222339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet ADD match_to_bet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BE7129C10 FOREIGN KEY (match_to_bet_id) REFERENCES `matchToBet` (id)');
        $this->addSql('CREATE INDEX IDX_FBF0EC9BE7129C10 ON bet (match_to_bet_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BE7129C10');
        $this->addSql('DROP INDEX IDX_FBF0EC9BE7129C10 ON bet');
        $this->addSql('ALTER TABLE bet DROP match_to_bet_id');
    }
}
