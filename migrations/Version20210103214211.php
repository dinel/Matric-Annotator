<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103214211 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annotator_judgement (id INT AUTO_INCREMENT NOT NULL, q_st1 VARCHAR(255) NOT NULL, q_st2 VARCHAR(255) NOT NULL, substitution_distortion_rate VARCHAR(255) NOT NULL, step2_explanation LONGTEXT NOT NULL, q_st3 VARCHAR(255) NOT NULL, omission_distortion_rate VARCHAR(255) NOT NULL, step3_explanation LONGTEXT NOT NULL, q_st4 VARCHAR(255) NOT NULL, addition_distortion_rate VARCHAR(255) NOT NULL, step4_explanation LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE annotator_judgement');
    }
}
