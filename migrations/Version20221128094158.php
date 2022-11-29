<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221128094158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_student (cours_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_F425C6487ECF78B0 (cours_id), INDEX IDX_F425C648CB944F1A (student_id), PRIMARY KEY(cours_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cours_student ADD CONSTRAINT FK_F425C6487ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_student ADD CONSTRAINT FK_F425C648CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours_student DROP FOREIGN KEY FK_F425C6487ECF78B0');
        $this->addSql('ALTER TABLE cours_student DROP FOREIGN KEY FK_F425C648CB944F1A');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_student');
    }
}
