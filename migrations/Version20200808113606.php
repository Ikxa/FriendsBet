<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200808113606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, rencontre_id INT DEFAULT NULL, winner VARCHAR(255) NOT NULL, score VARCHAR(100) NOT NULL, bet_at DATETIME NOT NULL, INDEX IDX_FBF0EC9B6CFC0818 (rencontre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet_user (bet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A8450575D871DC26 (bet_id), INDEX IDX_A8450575A76ED395 (user_id), PRIMARY KEY(bet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, match_id INT NOT NULL, team_one VARCHAR(255) NOT NULL, team_two VARCHAR(255) NOT NULL, played_at DATETIME NOT NULL, score_hometeam INT NOT NULL, score_awayteam INT NOT NULL, is_over TINYINT(1) NOT NULL, INDEX IDX_7A5BC505AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9B6CFC0818 FOREIGN KEY (rencontre_id) REFERENCES `match` (id)');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575D871DC26 FOREIGN KEY (bet_id) REFERENCES bet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC505AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_user DROP FOREIGN KEY FK_A8450575D871DC26');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9B6CFC0818');
        $this->addSql('ALTER TABLE `match` DROP FOREIGN KEY FK_7A5BC505AC78BCF8');
        $this->addSql('ALTER TABLE bet_user DROP FOREIGN KEY FK_A8450575A76ED395');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE bet_user');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE user');
    }
}
