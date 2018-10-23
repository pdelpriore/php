<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180925074651 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE motif DROP FOREIGN KEY FK_87D377BB2EF91FD8');
        $this->addSql('DROP INDEX UNIQ_87D377BB2EF91FD8 ON motif');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE motif ADD CONSTRAINT FK_87D377BB2EF91FD8 FOREIGN KEY (header_id) REFERENCES header (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87D377BB2EF91FD8 ON motif (header_id)');
    }
}
