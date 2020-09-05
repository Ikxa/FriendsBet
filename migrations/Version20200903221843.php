<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200903221843 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bet (id INT AUTO_INCREMENT NOT NULL, score_first_team INT DEFAULT NULL, score_second_team INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet_user (bet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A8450575D871DC26 (bet_id), INDEX IDX_A8450575A76ED395 (user_id), PRIMARY KEY(bet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `matchToBet` (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, first_team VARCHAR(255) NOT NULL, second_team VARCHAR(255) NOT NULL, score_first_team INT NOT NULL, score_second_team INT NOT NULL, played_at DATETIME NOT NULL, is_over TINYINT(1) NOT NULL, status VARCHAR(255) NOT NULL, winner INT NOT NULL, match_id INT NOT NULL, is_custom TINYINT(1) DEFAULT NULL, INDEX IDX_6842CB43AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575D871DC26 FOREIGN KEY (bet_id) REFERENCES bet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bet_user ADD CONSTRAINT FK_A8450575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `matchToBet` ADD CONSTRAINT FK_6842CB43AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('DROP TABLE `match`');
        $this->addSql('DROP TABLE warm');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bet_user DROP FOREIGN KEY FK_A8450575D871DC26');
        $this->addSql('CREATE TABLE `match` (id INT AUTO_INCREMENT NOT NULL, sport_id INT DEFAULT NULL, first_team VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, second_team VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, score_first_team INT NOT NULL, score_second_team INT NOT NULL, played_at DATETIME NOT NULL, is_over TINYINT(1) NOT NULL, status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, winner INT NOT NULL, match_id INT NOT NULL, is_custom TINYINT(1) DEFAULT NULL, INDEX IDX_7A5BC505AC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE warm (id INT AUTO_INCREMENT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, is_done TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `match` ADD CONSTRAINT FK_7A5BC505AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE bet_user');
        $this->addSql('DROP TABLE `matchToBet`');
        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
    }
}
