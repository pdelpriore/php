<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180823100959 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, activity_group_id INT NOT NULL, profil_id INT NOT NULL, name VARCHAR(50) NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, min_hours INT DEFAULT NULL, serial_number DOUBLE PRECISION NOT NULL, INDEX IDX_AC74095A5E5E6949 (activity_group_id), INDEX IDX_AC74095A275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, rate DOUBLE PRECISION DEFAULT NULL, serial_number INT DEFAULT NULL, automatic TINYINT(1) NOT NULL, referent TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, name VARCHAR(50) NOT NULL, rd_ref INT DEFAULT NULL, alias VARCHAR(10) NOT NULL, INDEX IDX_A45BDDC119EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, alias VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certainty_level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, alias VARCHAR(10) NOT NULL, dayly_cost DOUBLE PRECISION DEFAULT NULL, logo VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cyllene_person (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE header (id INT AUTO_INCREMENT NOT NULL, cyllene_person_id INT NOT NULL, application_id INT NOT NULL, in_charge_person_id INT NOT NULL, billing_id INT NOT NULL, description VARCHAR(255) NOT NULL, title VARCHAR(50) NOT NULL, application_version VARCHAR(10) DEFAULT NULL, redmine_id INT DEFAULT NULL, created_on DATETIME NOT NULL, updated_on DATETIME NOT NULL, deleted_on DATETIME DEFAULT NULL, estimate_version VARCHAR(10) NOT NULL, INDEX IDX_6E72A8C1363F2CFE (cyllene_person_id), INDEX IDX_6E72A8C13E030ACD (application_id), INDEX IDX_6E72A8C1B9D4015B (in_charge_person_id), INDEX IDX_6E72A8C13B025C87 (billing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE in_charge_person (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, department VARCHAR(150) NOT NULL, INDEX IDX_D858F1F319EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE in_charge_person_application (in_charge_person_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_84A4CEEAB9D4015B (in_charge_person_id), INDEX IDX_84A4CEEA3E030ACD (application_id), PRIMARY KEY(in_charge_person_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, dayly_cost DOUBLE PRECISION NOT NULL, default_selected TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A5E5E6949 FOREIGN KEY (activity_group_id) REFERENCES activity_group (id)');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C1363F2CFE FOREIGN KEY (cyllene_person_id) REFERENCES cyllene_person (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C13E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C1B9D4015B FOREIGN KEY (in_charge_person_id) REFERENCES in_charge_person (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C13B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('ALTER TABLE in_charge_person ADD CONSTRAINT FK_D858F1F319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE in_charge_person_application ADD CONSTRAINT FK_84A4CEEAB9D4015B FOREIGN KEY (in_charge_person_id) REFERENCES in_charge_person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE in_charge_person_application ADD CONSTRAINT FK_84A4CEEA3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail ADD rd_number INT DEFAULT NULL, ADD low_days DOUBLE PRECISION NOT NULL, ADD high_days DOUBLE PRECISION NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD created_on DATETIME NOT NULL, ADD updated_on DATETIME DEFAULT NULL, ADD automatic TINYINT(1) NOT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE estimated_days estimated_days DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F932EF91FD8 FOREIGN KEY (header_id) REFERENCES header (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F935E5E6949 FOREIGN KEY (activity_group_id) REFERENCES activity_group (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93B3F3DCFD FOREIGN KEY (certainty_level_id) REFERENCES certainty_level (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A5E5E6949');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F935E5E6949');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C13E030ACD');
        $this->addSql('ALTER TABLE in_charge_person_application DROP FOREIGN KEY FK_84A4CEEA3E030ACD');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C13B025C87');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93B3F3DCFD');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC119EB6921');
        $this->addSql('ALTER TABLE in_charge_person DROP FOREIGN KEY FK_D858F1F319EB6921');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C1363F2CFE');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F932EF91FD8');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C1B9D4015B');
        $this->addSql('ALTER TABLE in_charge_person_application DROP FOREIGN KEY FK_84A4CEEAB9D4015B');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A275ED078');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93275ED078');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_group');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE billing');
        $this->addSql('DROP TABLE certainty_level');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE cyllene_person');
        $this->addSql('DROP TABLE header');
        $this->addSql('DROP TABLE in_charge_person');
        $this->addSql('DROP TABLE in_charge_person_application');
        $this->addSql('DROP TABLE profil');
        $this->addSql('ALTER TABLE detail DROP rd_number, DROP low_days, DROP high_days, DROP price, DROP created_on, DROP updated_on, DROP automatic, CHANGE description description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE estimated_days estimated_days DOUBLE PRECISION NOT NULL');
    }
}
