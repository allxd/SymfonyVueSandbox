<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181022123650 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE secondname secondname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book DROP authorid, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE firstname firstname LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE secondname secondname LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE book ADD authorid INT NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
