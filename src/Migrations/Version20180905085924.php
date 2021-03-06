<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180905085924 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_A45BDDC1E16C6B94 ON application (alias)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EC224CAAE16C6B94 ON billing (alias)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E16C6B94 ON client (alias)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_A45BDDC1E16C6B94 ON application');
        $this->addSql('DROP INDEX UNIQ_EC224CAAE16C6B94 ON billing');
        $this->addSql('DROP INDEX UNIQ_C7440455E16C6B94 ON client');
    }
}
