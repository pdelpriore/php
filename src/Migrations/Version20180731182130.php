<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180731182130 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, header_id INT NOT NULL, activity_group_id INT NOT NULL, profil_id INT NOT NULL, certainty_level_id INT NOT NULL, description VARCHAR(255) NOT NULL, estimated_days DOUBLE PRECISION NOT NULL, calculated_days DOUBLE PRECISION NOT NULL, INDEX IDX_2E067F932EF91FD8 (header_id), INDEX IDX_2E067F935E5E6949 (activity_group_id), INDEX IDX_2E067F93275ED078 (profil_id), INDEX IDX_2E067F93B3F3DCFD (certainty_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F932EF91FD8 FOREIGN KEY (header_id) REFERENCES header (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F935E5E6949 FOREIGN KEY (activity_group_id) REFERENCES activity_group (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93B3F3DCFD FOREIGN KEY (certainty_level_id) REFERENCES certainty_level (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE detail');
    }
}
