<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180817172444 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE in_charge_person_application (in_charge_person_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_84A4CEEAB9D4015B (in_charge_person_id), INDEX IDX_84A4CEEA3E030ACD (application_id), PRIMARY KEY(in_charge_person_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE in_charge_person_application ADD CONSTRAINT FK_84A4CEEAB9D4015B FOREIGN KEY (in_charge_person_id) REFERENCES in_charge_person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE in_charge_person_application ADD CONSTRAINT FK_84A4CEEA3E030ACD FOREIGN KEY (application_id) REFERENCES application (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE in_charge_person_application');
    }
}
