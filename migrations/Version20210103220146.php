<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103220146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement ADD user_id INT DEFAULT NULL, ADD pair_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE annotator_judgement ADD CONSTRAINT FK_73A3A005A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE annotator_judgement ADD CONSTRAINT FK_73A3A0057EB8B2A3 FOREIGN KEY (pair_id) REFERENCES segment_pair (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_73A3A005A76ED395 ON annotator_judgement (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_73A3A0057EB8B2A3 ON annotator_judgement (pair_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement DROP FOREIGN KEY FK_73A3A005A76ED395');
        $this->addSql('ALTER TABLE annotator_judgement DROP FOREIGN KEY FK_73A3A0057EB8B2A3');
        $this->addSql('DROP INDEX UNIQ_73A3A005A76ED395 ON annotator_judgement');
        $this->addSql('DROP INDEX UNIQ_73A3A0057EB8B2A3 ON annotator_judgement');
        $this->addSql('ALTER TABLE annotator_judgement DROP user_id, DROP pair_id');
    }
}
