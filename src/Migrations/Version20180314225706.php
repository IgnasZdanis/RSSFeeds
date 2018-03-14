<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180314225706 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feed CHANGE title title VARCHAR(255) NOT NULL, CHANGE most_recent_article_title most_recent_article_title VARCHAR(255) DEFAULT NULL, CHANGE most_recent_article_url most_recent_article_url VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE feed CHANGE title title VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE most_recent_article_title most_recent_article_title VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE most_recent_article_url most_recent_article_url VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
