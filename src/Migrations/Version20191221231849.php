<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191221231849 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription() : string
    {
        return '';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, singles_ranking_id INT DEFAULT NULL, doubles_ranking_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, abbreviation VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, pro_year VARCHAR(255) DEFAULT NULL, handedness VARCHAR(255) DEFAULT NULL, height INT DEFAULT NULL, weight INT DEFAULT NULL, highest_singles_ranking INT DEFAULT NULL, highest_singles_ranking_date DATE DEFAULT NULL, api_id VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_98197A655840473C (singles_ranking_id), UNIQUE INDEX UNIQ_98197A65BF820DE0 (doubles_ranking_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_doubles_ranking (id INT AUTO_INCREMENT NOT NULL, rank INT NOT NULL, points INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_singles_ranking (id INT AUTO_INCREMENT NOT NULL, rank INT NOT NULL, points INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_statistics (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, year INT NOT NULL, surface VARCHAR(255) NOT NULL, tournament_played INT NOT NULL, tournament_won INT NOT NULL, matches_played INT NOT NULL, matches_won INT NOT NULL, INDEX IDX_BD760F1F99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, api_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A655840473C FOREIGN KEY (singles_ranking_id) REFERENCES player_singles_ranking (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65BF820DE0 FOREIGN KEY (doubles_ranking_id) REFERENCES player_doubles_ranking (id)');
        $this->addSql('ALTER TABLE player_statistics ADD CONSTRAINT FK_BD760F1F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player_statistics DROP FOREIGN KEY FK_BD760F1F99E6F5DF');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65BF820DE0');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A655840473C');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_doubles_ranking');
        $this->addSql('DROP TABLE player_singles_ranking');
        $this->addSql('DROP TABLE player_statistics');
        $this->addSql('DROP TABLE tournament');
    }
}
