<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105114050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement CHANGE q_st2 q_st2 VARCHAR(255) DEFAULT NULL, CHANGE substitution_distortion_rate substitution_distortion_rate VARCHAR(255) DEFAULT NULL, CHANGE step2_explanation step2_explanation LONGTEXT DEFAULT NULL, CHANGE q_st3 q_st3 VARCHAR(255) DEFAULT NULL, CHANGE step3_explanation step3_explanation LONGTEXT DEFAULT NULL, CHANGE q_st4 q_st4 VARCHAR(255) DEFAULT NULL, CHANGE addition_distortion_rate addition_distortion_rate VARCHAR(255) DEFAULT NULL, CHANGE step4_explanation step4_explanation LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annotator_judgement CHANGE q_st2 q_st2 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE substitution_distortion_rate substitution_distortion_rate VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE step2_explanation step2_explanation LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE q_st3 q_st3 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE step3_explanation step3_explanation LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE q_st4 q_st4 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE addition_distortion_rate addition_distortion_rate VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE step4_explanation step4_explanation LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
