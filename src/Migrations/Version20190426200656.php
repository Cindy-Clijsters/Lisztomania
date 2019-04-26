<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426200656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE label ADD created_by INT DEFAULT NULL, ADD updated_by INT DEFAULT NULL, ADD created DATETIME DEFAULT NULL, ADD updated DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E8DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE label ADD CONSTRAINT FK_EA750E816FE72E1 FOREIGN KEY (updated_by) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_EA750E8DE12AB56 ON label (created_by)');
        $this->addSql('CREATE INDEX IDX_EA750E816FE72E1 ON label (updated_by)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E8DE12AB56');
        $this->addSql('ALTER TABLE label DROP FOREIGN KEY FK_EA750E816FE72E1');
        $this->addSql('DROP INDEX IDX_EA750E8DE12AB56 ON label');
        $this->addSql('DROP INDEX IDX_EA750E816FE72E1 ON label');
        $this->addSql('ALTER TABLE label DROP created_by, DROP updated_by, DROP created, DROP updated, DROP deletedAt');
    }
}
