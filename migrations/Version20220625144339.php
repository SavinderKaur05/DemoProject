<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625144339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, employee_code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BA82C300A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, admission_number VARCHAR(255) NOT NULL, INDEX IDX_A4698DB2EA000B10 (class_id), UNIQUE INDEX UNIQ_A4698DB2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employees ADD CONSTRAINT FK_BA82C300A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE attendance_classes');
        $this->addSql('DROP TABLE attendance_students');
        $this->addSql('ALTER TABLE attendance ADD student_id INT NOT NULL, ADD class_id INT NOT NULL');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91CB944F1A ON attendance (student_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91EA000B10 ON attendance (class_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91EA000B10');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2EA000B10');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91CB944F1A');
        $this->addSql('ALTER TABLE employees DROP FOREIGN KEY FK_BA82C300A76ED395');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2A76ED395');
        $this->addSql('CREATE TABLE attendance_classes (attendance_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_52A90C7163DDA15 (attendance_id), INDEX IDX_52A90C79E225B24 (classes_id), PRIMARY KEY(attendance_id, classes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE attendance_students (attendance_id INT NOT NULL, students_id INT NOT NULL, INDEX IDX_4A602B70163DDA15 (attendance_id), INDEX IDX_4A602B701AD8D010 (students_id), PRIMARY KEY(attendance_id, students_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE attendance_classes ADD CONSTRAINT FK_52A90C7163DDA15 FOREIGN KEY (attendance_id) REFERENCES attendance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attendance_students ADD CONSTRAINT FK_4A602B70163DDA15 FOREIGN KEY (attendance_id) REFERENCES attendance (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP INDEX IDX_6DE30D91CB944F1A ON attendance');
        $this->addSql('DROP INDEX IDX_6DE30D91EA000B10 ON attendance');
        $this->addSql('ALTER TABLE attendance DROP student_id, DROP class_id');
    }
}
