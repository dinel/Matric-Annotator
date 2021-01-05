<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209123550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE segment_pair ADD segment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE segment_pair ADD CONSTRAINT FK_D6F99934DB296AAD FOREIGN KEY (segment_id) REFERENCES evaluation_task (id)');
        $this->addSql('CREATE INDEX IDX_D6F99934DB296AAD ON segment_pair (segment_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE segment_pair DROP FOREIGN KEY FK_D6F99934DB296AAD');
        $this->addSql('DROP INDEX IDX_D6F99934DB296AAD ON segment_pair');
        $this->addSql('ALTER TABLE segment_pair DROP segment_id');
    }
}
