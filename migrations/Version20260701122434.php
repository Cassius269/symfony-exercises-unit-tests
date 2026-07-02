<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260701122434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE id id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE book ADD category VARCHAR(255) NOT NULL, CHANGE id id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE book_author CHANGE book_id book_id BINARY(16) NOT NULL, CHANGE author_id author_id BINARY(16) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id BINARY(16) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE author CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE book DROP category, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE book_author CHANGE book_id book_id INT NOT NULL, CHANGE author_id author_id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
