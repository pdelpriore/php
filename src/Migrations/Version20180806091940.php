<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180806091940 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail ADD rd_number INT NOT NULL, ADD low_days DOUBLE PRECISION NOT NULL, ADD high_days DOUBLE PRECISION NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD created_on DATETIME NOT NULL, ADD updated_on DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE header ADD cyllene_person_id INT NOT NULL, ADD application_id INT NOT NULL, ADD in_charge_person_id INT NOT NULL, ADD billing_id INT NOT NULL, ADD title VARCHAR(50) NOT NULL, ADD application_version VARCHAR(10) NOT NULL, ADD redmine_id INT NOT NULL, ADD created_on DATETIME NOT NULL, ADD updated_on DATETIME NOT NULL, ADD deleted_on DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C1363F2CFE FOREIGN KEY (cyllene_person_id) REFERENCES cyllene_person (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C13E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C1B9D4015B FOREIGN KEY (in_charge_person_id) REFERENCES in_charge_person (id)');
        $this->addSql('ALTER TABLE header ADD CONSTRAINT FK_6E72A8C13B025C87 FOREIGN KEY (billing_id) REFERENCES billing (id)');
        $this->addSql('CREATE INDEX IDX_6E72A8C1363F2CFE ON header (cyllene_person_id)');
        $this->addSql('CREATE INDEX IDX_6E72A8C13E030ACD ON header (application_id)');
        $this->addSql('CREATE INDEX IDX_6E72A8C1B9D4015B ON header (in_charge_person_id)');
        $this->addSql('CREATE INDEX IDX_6E72A8C13B025C87 ON header (billing_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE detail DROP rd_number, DROP low_days, DROP high_days, DROP price, DROP created_on, DROP updated_on');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C1363F2CFE');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C13E030ACD');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C1B9D4015B');
        $this->addSql('ALTER TABLE header DROP FOREIGN KEY FK_6E72A8C13B025C87');
        $this->addSql('DROP INDEX IDX_6E72A8C1363F2CFE ON header');
        $this->addSql('DROP INDEX IDX_6E72A8C13E030ACD ON header');
        $this->addSql('DROP INDEX IDX_6E72A8C1B9D4015B ON header');
        $this->addSql('DROP INDEX IDX_6E72A8C13B025C87 ON header');
        $this->addSql('ALTER TABLE header DROP cyllene_person_id, DROP application_id, DROP in_charge_person_id, DROP billing_id, DROP title, DROP application_version, DROP redmine_id, DROP created_on, DROP updated_on, DROP deleted_on');
    }
}
