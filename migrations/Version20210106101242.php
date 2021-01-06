<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106101242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annotator_judgement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pair_id INT DEFAULT NULL, q_st1 VARCHAR(255) NOT NULL, q_st2 VARCHAR(255) DEFAULT NULL, substitution_distortion_rate VARCHAR(255) DEFAULT NULL, step2_explanation LONGTEXT DEFAULT NULL, q_st3 VARCHAR(255) DEFAULT NULL, omission_distortion_rate VARCHAR(255) DEFAULT NULL, step3_explanation LONGTEXT DEFAULT NULL, q_st4 VARCHAR(255) DEFAULT NULL, addition_distortion_rate VARCHAR(255) DEFAULT NULL, step4_explanation LONGTEXT DEFAULT NULL, INDEX IDX_73A3A005A76ED395 (user_id), INDEX IDX_73A3A0057EB8B2A3 (pair_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_task (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, src_lang VARCHAR(255) NOT NULL, trg_lang VARCHAR(255) NOT NULL, video VARCHAR(1024) DEFAULT NULL, title VARCHAR(1024) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE segment_pair (id INT AUTO_INCREMENT NOT NULL, segment_id INT DEFAULT NULL, source VARCHAR(2048) NOT NULL, target VARCHAR(2048) NOT NULL, offset INT DEFAULT NULL, prev INT DEFAULT NULL, next INT DEFAULT NULL, INDEX IDX_D6F99934DB296AAD (segment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task4_user (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, user_id INT DEFAULT NULL, complete INT NOT NULL, INDEX IDX_752142EB8DB60186 (task_id), INDEX IDX_752142EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annotator_judgement ADD CONSTRAINT FK_73A3A005A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE annotator_judgement ADD CONSTRAINT FK_73A3A0057EB8B2A3 FOREIGN KEY (pair_id) REFERENCES segment_pair (id)');
        $this->addSql('ALTER TABLE segment_pair ADD CONSTRAINT FK_D6F99934DB296AAD FOREIGN KEY (segment_id) REFERENCES evaluation_task (id)');
        $this->addSql('ALTER TABLE task4_user ADD CONSTRAINT FK_752142EB8DB60186 FOREIGN KEY (task_id) REFERENCES evaluation_task (id)');
        $this->addSql('ALTER TABLE task4_user ADD CONSTRAINT FK_752142EBA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE segment_pair DROP FOREIGN KEY FK_D6F99934DB296AAD');
        $this->addSql('ALTER TABLE task4_user DROP FOREIGN KEY FK_752142EB8DB60186');
        $this->addSql('ALTER TABLE annotator_judgement DROP FOREIGN KEY FK_73A3A0057EB8B2A3');
        $this->addSql('ALTER TABLE annotator_judgement DROP FOREIGN KEY FK_73A3A005A76ED395');
        $this->addSql('ALTER TABLE task4_user DROP FOREIGN KEY FK_752142EBA76ED395');
        $this->addSql('DROP TABLE annotator_judgement');
        $this->addSql('DROP TABLE evaluation_task');
        $this->addSql('DROP TABLE segment_pair');
        $this->addSql('DROP TABLE task4_user');
        $this->addSql('DROP TABLE `user`');
    }
}
