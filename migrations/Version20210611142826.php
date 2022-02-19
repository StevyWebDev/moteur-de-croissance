<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611142826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_user_role ADD CONSTRAINT FK_1EF34C53979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_user_role ADD CONSTRAINT FK_1EF34C53A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE company_user_role ADD CONSTRAINT FK_1EF34C53D60322AC FOREIGN KEY (role_id) REFERENCES role_company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_user_role DROP FOREIGN KEY FK_1EF34C53979B1AD6');
        $this->addSql('ALTER TABLE company_user_role DROP FOREIGN KEY FK_1EF34C53A76ED395');
        $this->addSql('ALTER TABLE company_user_role DROP FOREIGN KEY FK_1EF34C53D60322AC');
    }
}
