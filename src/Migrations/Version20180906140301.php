<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906140301 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parameter ADD param_key VARCHAR(20) NOT NULL, ADD param_value VARCHAR(255) NOT NULL, DROP hours_in_aday, DROP task_line, DROP time_laps, DROP logos_dir');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parameter ADD hours_in_aday INT NOT NULL, ADD time_laps INT NOT NULL, ADD logos_dir VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP param_key, CHANGE param_value task_line VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
