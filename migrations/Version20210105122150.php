<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105122150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement DROP INDEX UNIQ_73A3A0057EB8B2A3, ADD INDEX IDX_73A3A0057EB8B2A3 (pair_id)');
        $this->addSql('ALTER TABLE annotator_judgement DROP INDEX UNIQ_73A3A005A76ED395, ADD INDEX IDX_73A3A005A76ED395 (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement DROP INDEX IDX_73A3A005A76ED395, ADD UNIQUE INDEX UNIQ_73A3A005A76ED395 (user_id)');
        $this->addSql('ALTER TABLE annotator_judgement DROP INDEX IDX_73A3A0057EB8B2A3, ADD UNIQUE INDEX UNIQ_73A3A0057EB8B2A3 (pair_id)');
    }
}
