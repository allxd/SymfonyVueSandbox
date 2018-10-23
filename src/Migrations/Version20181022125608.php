<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181022125608 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE secondname secondname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD author_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', DROP authorid, CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331F675F31B ON book (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE author CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE firstname firstname LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE secondname secondname LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP INDEX IDX_CBE5A331F675F31B ON book');
        $this->addSql('ALTER TABLE book ADD authorid INT NOT NULL, DROP author_id, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
