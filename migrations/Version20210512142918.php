<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210512142918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_company_activity (company_id INT NOT NULL, company_activity_id INT NOT NULL, INDEX IDX_9A18E08C979B1AD6 (company_id), INDEX IDX_9A18E08C9811D80E (company_activity_id), PRIMARY KEY(company_id, company_activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_under_activity (company_id INT NOT NULL, under_activity_id INT NOT NULL, INDEX IDX_F97C3D9E979B1AD6 (company_id), INDEX IDX_F97C3D9EFE0AB462 (under_activity_id), PRIMARY KEY(company_id, under_activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE under_activity (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D7B4123D81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_company_activity ADD CONSTRAINT FK_9A18E08C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_company_activity ADD CONSTRAINT FK_9A18E08C9811D80E FOREIGN KEY (company_activity_id) REFERENCES company_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_under_activity ADD CONSTRAINT FK_F97C3D9E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_under_activity ADD CONSTRAINT FK_F97C3D9EFE0AB462 FOREIGN KEY (under_activity_id) REFERENCES under_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE under_activity ADD CONSTRAINT FK_D7B4123D81C06096 FOREIGN KEY (activity_id) REFERENCES company_activity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_company_activity DROP FOREIGN KEY FK_9A18E08C9811D80E');
        $this->addSql('ALTER TABLE under_activity DROP FOREIGN KEY FK_D7B4123D81C06096');
        $this->addSql('ALTER TABLE company_under_activity DROP FOREIGN KEY FK_F97C3D9EFE0AB462');
        $this->addSql('DROP TABLE company_company_activity');
        $this->addSql('DROP TABLE company_under_activity');
        $this->addSql('DROP TABLE company_activity');
        $this->addSql('DROP TABLE under_activity');
    }
}
