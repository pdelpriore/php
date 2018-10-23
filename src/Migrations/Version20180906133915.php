<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906133915 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parameter ADD time_laps INT NOT NULL, ADD logos_dir VARCHAR(255) NOT NULL, DROP time_lapse, DROP logos, CHANGE hours_in_aday hours_in_aday INT NOT NULL, CHANGE task_line task_line VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parameter ADD time_lapse INT DEFAULT NULL, ADD logos VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP time_laps, DROP logos_dir, CHANGE hours_in_aday hours_in_aday INT DEFAULT NULL, CHANGE task_line task_line VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
